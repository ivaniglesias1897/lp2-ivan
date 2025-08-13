<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class UserController extends Controller
{
    public function index()
    {
        # Listar datos de Usuarios
        $users = DB::select('select * from users ORDER BY id DESC');

        return view('users.index')->with('users', $users);
    }
    public function create()
    {
        return view('users.create');
    }
    public function store()
    {
        $input = request()->all();

        //Validar los datos del formulario
        $validator = Validator::make(
            $input,
            [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:6',
                'ci' => 'required|unique:users',
                'fecha_ingreso' => 'required|date',
            ],
            [
                'name.required' => 'El campo Nombre es obligatorio.',
                'email.required' => 'El campo Email es obligatorio.',
                'email.unique' => 'El nickname ya esta en uso.',
                'password.required' => 'El campo Password es obligatorio.',
                'password.min' => 'El campo Password debe tener al menos 6 caracteres.',
                'ci.required' => 'El campo CI es obligatorio.',
                'ci.unique' => 'El Nro de Doc. ya esta en uso',
                'fecha_ingreso.required' => 'El campo Fecha de Ingreso es obligatorio.',
                'fecha_ingreso.date' => 'El campo Fecha de Ingreso debe ser una fecha válida.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Si la Validacion pasa, guardar el usuario
        $contrasena = Hash::make($input['password']);

        DB::insert(
            'INSERT INTO users (name,email,password,ci,direccion,telefono,fecha_ingreso) 
        VALUES (?,?,?,?,?,?,?)',
            [
                $input['name'],
                $input['email'],
                $contrasena,
                $input['ci'],
                $input['direccion'],
                $input['telefono'],
                $input['fecha_ingreso'],
            ]
        );
        Flash::success('Usuario creado correctamente.');
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }
    public function edit($id)
    {
        // Obtenes los datos del usuario
        $users = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id]);
        if (empty($users)) {
            Flash::error('El usuario no fue encontrado.');
            return redirect()->route('users.index');
        }
        return view('users.edit')->with('users', $users);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();


        //Validar los datos del formulario
        $users = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id]);
        if (empty($users)) {
            Flash::error('El usuario no fue encontrado.');
            return redirect()->route('users.index');
        }

        $validacion = Validator::make(
            $input,
            [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $users->id, //Excluir el usuario actual de la validacion
                'password' => 'nullable|min:6',
                'ci' => 'required|unique:users,ci,' . $users->id, //Excluir el ci del usuario actual de la validacion
                'fecha_ingreso' => 'required|date',
            ],
            [
                'name.required' => 'El campo Nombre es obligatorio.',
                'email.required' => 'El campo Email es obligatorio.',
                'email.unique' => 'El nickname ya esta en uso.',
                'password.required' => 'El campo Password es obligatorio.',
                'password.min' => 'El campo Password debe tener al menos 6 caracteres.',
                'ci.required' => 'El campo CI es obligatorio.',
                'ci.unique' => 'El Nro de Doc. ya esta en uso',
                'fecha_ingreso.required' => 'El campo Fecha de Ingreso es obligatorio.',
                'fecha_ingreso.date' => 'El campo Fecha de Ingreso debe ser una fecha válida.',
            ]
        );

        if ($validacion->fails()) {
            Flash::error('Error de Validación.');
            return redirect()->back()->withErrors($validacion)->withInput();
        }

        //Validar si la contraseña ha sido cambiada
        $contrasena = null;
        if (!empty($input['password']) && !Hash::check($input['password'], $users->password)) {
            $contrasena = Hash::make($input['password']); //Encriptar la contraseña
        } else {
            $contrasena = $users->password; // mantener la contraseña sin encriptar
        }

        //Si la Validacion pasa, actualizar el usuario
        DB::update(
            'UPDATE users SET name = ?, email = ?, ci = ?, password = ?, direccion = ?, telefono = ?, fecha_ingreso = ? WHERE id = ?',
            [
                $input['name'],
                $input['email'],
                $input['ci'],
                $contrasena,
                $input['direccion'],
                $input['telefono'],
                $input['fecha_ingreso'],
                $id,
            ]
        );
        Flash::success('Usuario actualizado correctamente.');
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    public function destroy($id)
    {
        $users = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id]);
        if (empty($users)) {
            Flash::error('El usuario no fue encontrado.');
            return redirect()->route('users.index');
        }
        //Validar si debe inactivar o activar el usuario segun lo recuperado en la consulta
        $estado = $users->estado == false ? true : false;

        DB::update('UPDATE users SET estado = ? WHERE id = ?',
            [
                $estado, //valor boolean ya que el campo estado es tipo booleano
                $id
            ]
        );
        // Generar el mensaje sugun estado del usuario
        $mensaje = $estado == true ? 'Usuario activado correctamente' : 'Usuario inactivado correctamente';

        Flash::success($mensaje);

        return redirect()->route('users.index');
    }
}
