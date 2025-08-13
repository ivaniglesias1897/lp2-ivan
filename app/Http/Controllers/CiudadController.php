<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CiudadController extends Controller
{
    public function index()
    {
        // Obtener las Ciudades
        $ciudades = DB::select(
            'SELECT c.*, d.descripcion as departamento
         FROM ciudades c
         JOIN departamentos d ON c.id_departamento = d.id_departamento
         ORDER BY c.id_ciudad DESC'
        );
        return view('ciudades.index')->with('ciudades', $ciudades);
    }
    public function create()
    {
        //Mostrar departamentos en la vista
        $departamentos = DB::table('departamentos')->pluck('descripcion', 'id_departamento');
        return view('ciudades.create')->with('departamentos', $departamentos);
    }
    public function store(Request $request)
    {
        //recibe todos los parametros
        $input = $request->all();
        $validacion = Validator::make(
            $input,
            [
                'descripcion' => 'required',
                'id_departamento' => 'required|exists:departamentos,id_departamento'
            ],
            [
                'descripcion.required' => 'La descripcion es obligatorio',
                'id_departamento.required' => 'El id_departamento es obligatorio',
                'id_departamento.exists' => 'El id_departamento no existe'
            ]
        );
        //SI LA VALIDACION FALLA, REDIRIGIR CON ERRORES
        if ($validacion->fails()) {
            return redirect()->back()->withErrors($validacion->errors());
        }
        //GUARDAR LA NUEVA CIUDAD
        DB::insert(
            'INSERT INTO ciudades (descripcion, id_departamento) values (?, ?)',
            [
                $input['descripcion'],
                $input['id_departamento']
            ]
        );

        Flash::success("La ciudad fue creada con éxito.");
        //REDIRIGIR A LA VISTA CIUDADES
        return redirect()->route('ciudades.index');
    }
    public function edit($id)
    {
        //SELECTONE recupera solo una ciudad
        $ciudad = DB::selectOne('SELECT * FROM ciudades WHERE id_ciudad = ?', [$id]);
        if (empty($ciudad)) {
            flash('Ciudad no encontrada');
            return redirect()->route('ciudades.index');
        }
        $departamentos = DB::table('departamentos')->pluck('descripcion', 'id_departamento');
        return view('ciudades.edit')->with('ciudades', $ciudad)
            ->with('departamentos', $departamentos);
    }
    public function update(Request $request, $id)
    {
        //Validar y actualizar la ciudad
        $input = $request->all();
        $ciudad = DB::selectOne(
            'SELECT * FROM ciudades WHERE id_ciudad = ?',
            [$id]
        );
        if (empty($ciudad)) {
            flash('Ciudad no encontrada');
            return redirect()->route('ciudades.index');
        }
        $validacion = Validator::make(
            $input,
            [
                'descripcion' => 'required',
                'id_departamento' => 'required|exists:departamentos,id_departamento'
            ],
            [
                'descripcion.required' => 'La descripcion es obligatorio',
                'id_departamento.required' => 'El id_departamento es obligatorio',
                'id_departamento.exists' => 'El id_departamento no existe'
            ]
        );

        if ($validacion->fails()) {
            return redirect()->back()->withErrors($validacion->errors());
        }

        DB::update(
            'UPDATE ciudades SET descripcion = ?, id_departamento = ? WHERE id_ciudad = ?',
            [
                $input['descripcion'],
                $input['id_departamento'],
                $id
            ]
        );
        
        Flash::success("La ciudad fue actualizada con éxito.");
        return redirect()->route('ciudades.index');
    }
    public function destroy($id)
    {
        //Eliminar ciudad por su id
        $ciudad = DB::selectOne('SELECT * FROM ciudades WHERE id_ciudad = ?', [$id]);
        if (empty($ciudad)) {
            flash('Ciudad no encontrada');
            return redirect()->route('ciudades.index');
        }
        DB::delete('DELETE FROM ciudades WHERE id_ciudad = ?', [$id]);
        Flash::success("La ciudad fue eliminada con éxito.");
        return redirect()->route('ciudades.index');
    }
}
