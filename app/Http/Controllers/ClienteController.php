<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //
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
