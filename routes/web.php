<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homeWork', function () {
    return view('principal');
});

#Estacion
Route::resource('estacion', 'EstacionController');

#Rol
Route::resource('rol', 'RolController');

#Sesion
Route::resource('sesion', 'SesionTrabajoController');
Route::post('/sesionFinal', 'SesionTrabajoController@storeFinal');

#Cliente
Route::get('/homee', 'ClienteController@index');

#Ot
Route::get('/otAbierta', 'OtController@obtenerOtAbierta');

#Producto
Route::get('/productosOt/{id}', 'ProductoController@obtenerProductosOt');
Route::post('/cantidadProducto', 'ProductoController@obtenerCantidadPorOt');

#SubProducto 
Route::get('/subProductos/{id}', 'SubProductoController@subProductosDeProducto');

#Proceso
Route::get('/procesos/{id}','ProcesoController@obtenerProcesosPorEstacion');

#Usuario
Route::get('/trabajadores/{id}', 'UsuarioController@obtenerTrabajadoresPorEstacion');

#TipoMaterial
Route::get('/tipoMaterialFiltrador', 'TipoMaterialController@obtenerIdFiltrador');



/*  <!--@foreach ($clientes as $cliente)
            <p>{{ $cliente->nombre }}</p>
            <p>{{ $cliente->codigo }}</p>
        @endforeach--> */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
