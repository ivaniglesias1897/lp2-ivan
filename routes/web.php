<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

## Crear rutas para Cargo de todas las acciones
Route::resource('cargos', App\Http\Controllers\CargoController::class);
## Crear rutas para Departamento de todas las acciones
Route::resource('departamentos', App\Http\Controllers\DepartamentoController::class);
## Crear rutas para Proveedor de todas las acciones
Route::resource('proveedores', App\Http\Controllers\ProveedorController::class);
## Crear rutas para Marca de todas las acciones
Route::resource('marcas', App\Http\Controllers\MarcaController::class);
## Crear rutas para Ciudad de todas las acciones
Route::resource('ciudades', App\Http\Controllers\CiudadController::class);
## Crear rutas para Producto de todas las acciones
Route::resource('productos', App\Http\Controllers\ProductoController::class);
## Crear rutas para Sucursal de todas las acciones
Route::resource('sucursales', App\Http\Controllers\SucursalController::class);
## Crear rutas para Caja de todas las acciones
Route::resource('cajas', App\Http\Controllers\CajaController::class);
## Crear rutas para Users
Route::resource('users', App\Http\Controllers\UserController::class);
## Crear rutas para Clientes
Route::resource('clientes', App\Http\Controllers\ClienteController::class);