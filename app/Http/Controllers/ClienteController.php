<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = DB::select('
        SELECT c.*, ciu.descripcion as ciudad,
        d.descripcion as departamento
        FROM clientes c
        JOIN ciudades ciu ON ciu.id_ciudad = c.id_ciudad
        JOIN departamentos d ON d.id_departamento = c.id_departamento
        ');

        return view('clientes.index')->with('clientes', $clientes);
    }
    public function create()
    {
        //Armar consulta para cargar ciudad y departamento para el select
        $ciudades = DB::table('ciudades')->pluck('descripcion', 'id_ciudad');
        $departamentos = DB::table('departamentos')->pluck('descripcion', 'id_departamento');
        //dd($ciudades); para ver lo que llega

        return view('clientes.create')->with('ciudades', $ciudades)
            ->with('departamentos', $departamentos);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        ##Obtener la fecha actual
        $fec_actual = Carbon::now();
        ##Parsear la fecha de nacimiento input clie_fecha_nac
        $fecha_nac = Carbon::parse($input['clie_fecha_nac']);
        #dd($fec_actual,$fecha_nac);
        
        $validation = Validator::make(
            $input,
            [
                'clie_nombre.required',
                'clie_apellido.required',
                #'clie_ci.required |unique:clientes,clie_ci|max:8',
                'clie_fecha_nac.required| date',
                'id_departamento.required|exists:departamentos,id_departamento',
                'id_ciudad.required|exists:ciudades,id_ciudad',
            ],
            [
                'clie_nombre.required' => 'Campo nombre es obligatorio',
                'clie_apellido.required' => 'Campo apellido es obligatorio',
                'clie_ci.required' => 'Campo CI es obligatorio',
                'clie_ci.unique' => 'El dato CI ya existe',
                #'clie_ci.max' => 'El dato CI debe tener 8 caracteres',
                'clie_fecha_nac.required' => 'Campo fecha de nacimiento es obligatoria',
                'clie_fecha_nac.date' => 'La fecha de nacimiento debe ser una fecha válida',
                'id_departamento.required' => 'Campo departamento es obligatorio',
                'id_departamento.exists' => 'El campo departamento debe ser un departamento válido',
                'id_ciudad.required' => 'Campo ciudad es obligatoria',
                'id_ciudad.exists' => 'El campo ciudad debe ser una ciudad válida',

            ]
        );
        ##Validar edad del cliente
        $edad = $fec_actual->diffInYears($fecha_nac);
        if ($edad < 18) {
           Flash::error('El cliente debe ser mayor de 18 años');
           return redirect()->route('clientes.create')->withInput();
        }
        ##Validar fecha mayor a la actual
        if ($fecha_nac > $fec_actual) {
            Flash::error('La fecha de nacimiento no puede ser mayor a la fecha actual');
            return redirect()->route('clientes.create')->withInput();
        }
        

        ##Validar cantidad de digitos del campo ci
        $ci = strlen($input['clie_ci']); // utilizar strlen para contar la cantidad de caracteres
        if ($ci > 8) { #mayor a 8 caracteres
            Flash::error('El nro. de cedula solo podra contener 8 digitos');
            return redirect()->route('clientes.create')->withInput();
        }
        #Insertar datos de Clientes
        DB::insert('INSERT INTO clientes (clie_nombre, clie_apellido, clie_ci,clie_telefono,clie_direccion, clie_fecha_nac, id_departamento, id_ciudad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
            $input['clie_nombre'],
            $input['clie_apellido'],
            $input['clie_ci'],
            $input['clie_telefono'],
            $input['clie_direccion'],
            $input['clie_fecha_nac'],
            $input['id_departamento'],
            $input['id_ciudad'],
        ]);
        Flash::success('Cliente creado correctamente');
        return redirect()->route('clientes.index');
    
    }
    public function edit($id)
    {
        $clientes = DB::selectOne('SELECT * FROM clientes WHERE id_cliente = ?', [$id]);
        
        if (empty($clientes)) {
            Flash::error('Cliente no encontrado');
            return redirect()->route('clientes.index');
        }
        //Armar consulta para cargar ciudad y departamento para el select en editar
        $ciudades = DB::table('ciudades')->pluck('descripcion', 'id_ciudad');
        $departamentos = DB::table('departamentos')->pluck('descripcion', 'id_departamento');

        return view('clientes.edit')->with('clientes', $clientes)
            ->with('ciudades', $ciudades)
            ->with('departamentos', $departamentos);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        //Validar que exista el cliente antes de procesar
        $clientes = DB::selectOne('SELECT * FROM clientes WHERE id_cliente = ?', [$id]);
        
        if (empty($clientes)) {
            Flash::error('Cliente no encontrado');
            return redirect()->route('clientes.index');
        }

        //Validacion
        $validation = Validator::make(
            $input,
            [
                'clie_nombre.required',
                'clie_apellido.required',
                #'clie_ci.required |unique:clientes,clie_ci|max:8',
                'clie_fecha_nac.required| date',
                'id_departamento.required|exists:departamentos,id_departamento',
                'id_ciudad.required|exists:ciudades,id_ciudad',
            ],
            [
                'clie_nombre.required' => 'Campo nombre es obligatorio',
                'clie_apellido.required' => 'Campo apellido es obligatorio',
                'clie_ci.required' => 'Campo CI es obligatorio',
                'clie_ci.unique' => 'El dato CI ya existe',
                #'clie_ci.max' => 'El dato CI debe tener 8 caracteres',
                'clie_fecha_nac.required' => 'Campo fecha de nacimiento es obligatoria',
                'clie_fecha_nac.date' => 'La fecha de nacimiento debe ser una fecha válida',
                'id_departamento.required' => 'Campo departamento es obligatorio',
                'id_departamento.exists' => 'El campo departamento debe ser un departamento válido',
                'id_ciudad.required' => 'Campo ciudad es obligatoria',
                'id_ciudad.exists' => 'El campo ciudad debe ser una ciudad válida',

            ]
        );
        if($validation->fails()){
            Flash::error('Error de validación');
            return redirect()->route('clientes.edit', $id)->withErrors($validation)->withInput();
        }

        ##Validacion de edad del cliente
        $fec_actual = Carbon::now();
        $fecha_nac = Carbon::parse($input['clie_fecha_nac']);

        $edad = $fec_actual->diffInYears($fecha_nac);
        if ($edad < 18 || $fecha_nac > $fec_actual) {
           Flash::error('El cliente debe ser mayor de 18 años y la fecha de nacimiento debe ser menor a la fecha actual');
           return redirect()->route('clientes.edit', $id)->withInput();
        }
       // if ($fecha_nac > $fec_actual) {
      //      Flash::error('La fecha de nacimiento no puede ser mayor a la fecha actual');
       //     return redirect()->route('clientes.edit')->withInput();
     //   }
        ##Validar cantidad de digitos del campo ci
        $ci = strlen($input['clie_ci']); // utilizar strlen para contar la cantidad de caracteres
        if ($ci > 8) { #mayor a 8 caracteres
            Flash::error('El nro. de cedula solo podra contener 8 digitos');
            return redirect()->route('clientes.edit', $id)->withInput();
        }
        DB::update('UPDATE clientes SET 
        clie_nombre = ?, 
        clie_apellido = ?, 
        clie_ci = ?, 
        clie_telefono = ?, 
        clie_direccion = ?, 
        clie_fecha_nac = ?, 
        id_departamento = ?, 
        id_ciudad = ? 
        WHERE id_cliente = ?', [
            $input['clie_nombre'],  
            $input['clie_apellido'],
            $input['clie_ci'],
            $input['clie_telefono'],
            $input['clie_direccion'],
            $input['clie_fecha_nac'],
            $input['id_departamento'],
            $input['id_ciudad'],
            $id
        ]);
        Flash::success('Cliente actualizado correctamente');
        return redirect()->route('clientes.index');
    }
    public function destroy($id)
    {
        $clientes = DB::selectOne('SELECT * FROM clientes WHERE id_cliente = ?', [$id]);
        if (empty($clientes)) {
            Flash::error('Cliente no encontrado');
            return redirect()->route('clientes.index');
        }
        #Utlizaremos Try catch en Clientes 
        try {
            DB::delete('DELETE FROM clientes WHERE id_cliente = ?', [$id]);
            Flash::success('Cliente eliminado correctamente');
        } catch (\Exception $e) { //exception capturada desde la base de datos
            Flash::error('Error al eliminar el cliente. Por motivo: ' . $e->getMessage());
        }
        return redirect()->route('clientes.index');
    }
}
