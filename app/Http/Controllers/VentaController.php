<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = DB::select(
            "SELECT v.*, concat(c.clie_nombre, ' ', c.clie_apellido) AS cliente, c.clie_ci,
            users.name as usuarios
            FROM ventas v
            JOIN clientes c ON v.id_cliente = c.id_cliente
            JOIN users ON v.user_id = users.id
            ORDER BY v.fecha_venta DESC"
        );
        return view('ventas.index')->with('ventas', $ventas);
    }
    public function create()
    {
        //Crear select para clientes
        $clientes = DB::table('clientes')
        ->selectRaw("id_cliente, concat(clie_nombre,' ', clie_apellido) as cliente")
        ->pluck('cliente', 'id_cliente');
        
        //Comparir el usuario en sesion para el formulario ventas utilizando auth()
        $usuario = auth()->user()-> name;

        //Condicion de venta opciones: CONTADO O CREDITO
        $condicion_venta = [
            'CONTADO' => 'CONTADO',
            'CREDITO' => 'CREDITO',
        ];

        // Intervalo de vencimiento
        $intervalo_vencimiento = [
            '7' => '7 Días',
            '15' => '15 Días',
            '30' => '30 Días',
        ];

        return view('ventas.create')->with('clientes', $clientes)
        ->with('usuario', $usuario)
        ->with('condicion_venta', $condicion_venta)
        ->with('intervalo_vencimiento', $intervalo_vencimiento);
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
