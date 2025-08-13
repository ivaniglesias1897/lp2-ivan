<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = DB::select('select * from departamentos');
        return view('departamentos.index')->with('departamentos', $departamentos);
    }
    public function create()
    {
        // retornar la vista con el formulario de departamentos create
        return view('departamentos.create');
    }
    public function store(Request $request)
    {
        // recibir los datos del formulario
        $input = $request->all();

        // validar los datos del formulario
        $validator = Validator::make(
            $input,
            [
                'descripcion' => 'required',
            ],
            [
                'descripcion.required' => 'El campo descripción es obligatorio.',
            ]
        );

        // Imprimir el error si la validacion falla
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        // Si la validación pasa, guardar el nuevo departamento utilizando la función insert de la base de datos
        DB::insert(
            'insert into departamentos (descripcion) values (?)',
            [
                $input['descripcion']
            ]
        );

        ## Imprimir mensaje de éxito y redirigir a la vista index
        Flash::success("El departamento fue creado con éxito.");
        return redirect(route('departamentos.index'));
    }
    public function edit($id)
    {
        // Obtener el departamento por su ID utilizando la función select de la base de datos segun $id recibido
        $departamento = DB::selectOne('select * from departamentos where id_departamento = ?', [$id]);

        // Verificar si el departamento existe y no está vacío
        if (empty($departamento)) {
            Flash::error("El departamento no fue encontrado.");
            // Redirigir a la vista index si el departamento no existe
            return redirect()->route('departamentos.index');
        }

        // Retornar la vista con el formulario de edición
        return view('departamentos.edit')->with('departamento', $departamento);
    }
    public function update(Request $request, $id)
    {
        // Actualizar el departamento utilizando la función update de la base de datos
        $input = $request->all();
        // Obtener el departamento por su ID utilizando la función select de la base de datos segun $id recibido
        $departamento = DB::selectOne('select * from departamentos where id_departamento = ?', [$id]);
        // Verificar si el departamento existe y no está vacío
        if (empty($departamento)) {
            Flash::error("El Departamento no fue encontrado.");
            // Redirigir a la vista index si el departamento no existe
            return redirect()->route('departamentos.index');
        }

        // Validar los datos de entrada utilizando la clase Validator de Laravel
        $validator = Validator::make(
            $input,
            [
                'descripcion' => 'required',
            ],
            [
                'descripcion.required' => 'El campo descripción es obligatorio.',
            ]
        );

        // Imprimir los errores de validación si existen
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::update('update departamentos set descripcion = ? where id_departamento = ?', 
            [
                $input['descripcion'],
                $id
            ]
        );

        // Imprimir mensaje de éxito y redirigir a la vista index
        Flash::success("El departamento fue actualizado con éxito.");
        return redirect(route('departamentos.index'));
    }

    public function destroy($id)
    {
        //Obtener el departamento por ID utilizando l funcion select de la base de datos segun $id recibido
        $departamento = DB::selectOne('select * from departamentos where id_departamento = ?', [$id]);
        // Verificar si el departamento existe y no esta vacio
        if (empty($departamento)) {
            Flash::error("El Departamento no fue encontrado.");
            // Redirigir a la vista index si el departamento no existe
            return redirect()->route('departamentos.index');
        }
        // Eliminar el departamento utilizando la función delete de la base de datos
        DB::delete('delete from departamentos where id_departamento = ?', [$id]);

        // Imprimir mensaje de éxito y redirigir a la vista index
        Flash::success("El departamento fue eliminado con éxito.");
        return redirect(route('departamentos.index'));
    }
}

