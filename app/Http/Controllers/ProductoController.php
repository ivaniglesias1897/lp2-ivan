<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index(){
        $productos = DB::select(
            'SELECT p.*, m.descripcion as marcas
            FROM productos p
            JOIN marcas m ON p.id_marca = m.id_marca
            ORDER BY p.id_producto DESC'
        );
        return view('productos.index')->with('productos', $productos);
    }
    public function create()
    {
        //cargar los tipos de iva
        $tipo_iva = array(
            '0' => 'Exento',
            '5' => 'Gravada 5%',
            '10' => 'Gravada 10%'
        );
        //Obtener marcas
        $marcas = DB::table('marcas')->pluck('descripcion', 'id_marca');

        return view('productos.create')->with('tipo_iva', $tipo_iva)->with('marcas', $marcas);
    }
    public function store(Request $request)
    {
        $input = $request->all();

        //Validar los datos
        $validacion = Validator::make($input, [
            'descripcion' => 'required',
            'precio' => 'required',
            'id_marca' => 'required|exists:marcas,id_marca',
            'tipo_iva' => 'required|numeric',
        ], [
            'descripcion.required' => 'La descripcion es obligatoria',
            'precio.required' => 'El precio es obligatorio',
            'id_marca.required' => 'La marca es obligatoria',
            'id_marca.exists' => 'La marca no existe',
            'tipo_iva.required' => 'El tipo de iva es obligatorio',
            'tipo_iva.numeric' => 'El tipo de iva debe ser numerico',
        ]);
        //si la validacion falla, redirigir con errores
        if ($validacion->fails()) {
            return redirect()->back()
                ->withErrors($validacion)
                ->withInput();
        }
        //Sacar separadores de miles y cambiar por vacios en el precio
        $precio = str_replace('.', '', $input['precio']);

        //Insertar el nuevo producto en la Base de datos
        DB::insert(
            'INSERT INTO productos (descripcion, precio, id_marca, tipo_iva) VALUES (?, ?, ?, ?)',
            [
                $input['descripcion'],
                $precio,
                $input['id_marca'],
                $input['tipo_iva']
            ]
        );
        //Redirigir a la lista de productos con un mesaje de exito
        flash('Producto creado con exito');
        return redirect(route('productos.index'));
    }
    public function edit($id)
    {
        $productos = DB::selectOne('SELECT * FROM productos WHERE id_producto = ?', [$id]); //SELECTONE devuelve un objeto()
        //Validar si el producto no existe, redirigir con un mesaje de error
        if (empty($productos)) {
            flash('Producto no encontrado');
            return redirect()->route('productos.index');
        }
        //cargar los tipos de iva
        $tipo_iva = array(
            '0' => 'Exento',
            '5' => 'Gravada 5%',
            '10' => 'Gravada 10%'
        );
        //Obtener marcas
        $marcas = DB::table('marcas')->pluck('descripcion', 'id_marca');
        return view('productos.edit')->with('productos', $productos)->with('tipo_iva', $tipo_iva)->with('marcas', $marcas);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        //Obtener el producto de la base de datos  1 solo valor utilizando selectOne
        $producto = DB::selectOne('SELECT * FROM productos WHERE id_producto = ?', [$id]);
        //Validar si el producto no existe, redirigir con un mesaje de error
        if (empty($producto)) {
            flash('Producto no encontrado');
            return redirect()->route('productos.index');
        }
        //Validar los datos
        $validacion = Validator::make($input, [
            'descripcion' => 'required',
            'precio' => 'required',
            'id_marca' => 'required|exists:marcas,id_marca',
            'tipo_iva' => 'required|numeric',
        ], [
            'descripcion.required' => 'La descripcion es obligatoria',
            'precio.required' => 'El precio es obligatorio',
            'id_marca.required' => 'La marca es obligatoria',
            'id_marca.exists' => 'La marca no existe',
            'tipo_iva.required' => 'El tipo de iva es obligatorio',
            'tipo_iva.numeric' => 'El tipo de iva debe ser numerico',
        ]);
        //si la validacion falla, redirigir con errores
        if ($validacion->fails()) {
            return redirect()->back()
                ->withErrors($validacion)
                ->withInput();
        }
        //Sacar separadores de miles y cambiar por vacios en el precio
        $precio = str_replace('.', '', $input['precio']);

        //Actualizar el producto en la Base de datos
        DB::update(
            'UPDATE productos SET descripcion = ?, precio = ?, id_marca = ?, tipo_iva = ? WHERE id_producto = ?',
            [
                $input['descripcion'],
                $precio,
                $input['id_marca'],
                $input['tipo_iva'],
                $id
            ]
        );
        //Redirigir a la lista de productos con un mesaje de exito
        flash('Producto actualizado con exito');
        return redirect(route('productos.index'));

    }
    public function destroy($id)
    {
        //Validar si el producto no existe
        $producto = DB::delete('DELETE FROM productos WHERE id_producto = ?', [$id]);
        if (empty($producto)) {
            flash('Producto no encontrado');
            return redirect()->route('productos.index');
        }
        //Eliminar el producto de la base de datos
        DB::delete('DELETE FROM productos WHERE id_producto = ?', [$id]);
        
        //Redirigir a la lista de productos con un mesaje de exito
        flash('Producto eliminado con exito');

        return redirect(route('productos.index'));
    }
}
