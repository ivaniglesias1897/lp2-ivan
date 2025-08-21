<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = DB::select(
            "SELECT v.*, concat(c.clie_nombre, ' ', c.clie_apellido) AS cliente, c.clie_ci,
            users.name as usuario
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
        $usuario = auth()->user()->name;

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
        $input = $request->all();

        $input['intervalo'] = $input['intervalo'] ?? '0';
        $input['cantidad_cuota'] = $input['cantidad_cuota'] ?? '0';
        
        $validacion = Validator::make($input, [
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'condicion_venta' => 'required|in:CONTADO,CREDITO',
            'intervalo' => 'required_if:condicion_venta,CREDITO|in:0,7,15,30',
            'cantidad_cuota' => 'required_if:condicion_venta,CREDITO|integer',
            'fecha_venta' => 'required|date',
        ],
        [
            'id_cliente.required' => 'El campo cliente es obligatorio',
            'id_cliente.exists' => 'El cliente seleccionado no existe',
            'condicion_venta.required' => 'Seleccione una condicion de venta',
            'condicion_venta.in' => 'La condicion de venta seleccionada no es válida',
            'intervalo.required_if' => 'El campo intervalo es obligatorio',
            'intervalo.in' => 'El intervalo seleccionado no es válido',
            'cantidad_cuota.required_if' => 'El campo cantidad de cuotas es obligatorio cuando la condicion de venta es credito',
            'cantidad_cuota.integer' => 'La cantidad de cuotas debe ser un número entero',
            'fecha_venta.required' => 'El campo fecha de venta es obligatorio',
            'fecha_venta.date' => 'El campo fecha de venta debe ser una fecha válida',
            'user_id.required' => 'El campo usuario es obligatorio',
            'user_id.exists' => 'El usuario seleccionado no es valido',
        ]);

        if ($validacion->fails()) {
            return redirect()->back()->withErrors($validacion)->withInput();
        }

        $user_id = auth()->user()->id;
        $ventas = DB::table('ventas')->insertGetId([
            
            'id_cliente' => $input['id_cliente'],
            'condicion_venta' => $input['condicion_venta'],
            'intervalo' => $input['intervalo'] ?? '0',
            'cantidad_cuota' => $input['cantidad_cuota'] ?? '0',
            'fecha_venta' => $input['fecha_venta'],
            'factura_nro' => $input['factura_nro'] ?? '0',
            'user_id' => $user_id,
            'total' => $input['total' ?? '0'],
            'estado' => 'COMPLETADO',
        ], 'id_venta');

        Flash::success('Venta registrada exitosamente.');
        return redirect()->route('ventas.index');
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
