<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validation = Validator::make(
            $input,
            [
                'clie_nombre.required',
                'clie_apellido.required',
                'clie_ci.required |unique:clientes,clie_ci',
                'clie_fecha_nac.required| date',
                'id_departamento.required|exists:departamentos,id_departamento',
                'id_ciudad.required|exists:ciudades,id_ciudad',
            ],
            [
                'clie_nombre.required' => 'Campo nombre es obligatorio',
                'clie_apellido.required' => 'Campo apellido es obligatorio',
                'clie_ci.required' => 'Campo CI es obligatorio',
                'clie_ci.unique' => 'El dato CI ya existe',
                'clie_fecha_nac.required' => 'Campo fecha de nacimiento es obligatoria',
                'clie_fecha_nac.date' => 'La fecha de nacimiento debe ser una fecha válida',
                'id_departamento.required' => 'Campo departamento es obligatorio',
                'id_departamento.exists' => 'El campo departamento debe ser un departamento válido',
                'id_ciudad.required' => 'Campo ciudad es obligatoria',
                'id_ciudad.exists' => 'El campo ciudad debe ser una ciudad válida',

            ]
        );
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
