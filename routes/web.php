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

//Route::get('/homeWork', function () {
    //return view('principal');
//});

#Estacion
Route::resource('estacion', 'EstacionController');

#Rol
Route::resource('rol', 'RolController');

#Sesion
Route::resource('sesion', 'SesionTrabajoController');
Route::post('/sesionFinal', 'SesionTrabajoController@storeFinal');



#Ot
Route::resource('ot','OtController');
Route::get('/otAbierta', 'OtController@obtenerOtAbierta'); 
Route::get('/productosYCantidadOt/{id}', 'OtController@obtenerProductos');
Route::get('/obtenerClienteOt/{id}', 'OtController@obtenerClienteOt');
Route::get('/obtenerCanalOt/{id}', 'OtController@obtenerCanalVentaOt');
Route::get('/obtenerTipoOt/{id}', 'OtController@obtenerTipoOt');
Route::get('/obtenerResponsableOt/{id}', 'OtController@obtenerResponsableOt');
Route::get('/obtenerTodoOt/{id}', 'OtController@obtenerTodoOt');
Route::get('/seleccionados/{id}', 'OtController@seleccionados');
Route::get('/cerrarOt/{id}', 'OtController@cerrarOt');
Route::get('/abrirOt/{id}', 'OtController@abrirOt');
Route::post('/exportarExcel', 'OtController@exportarExcel');
Route::get('/test', 'OtController@test');

#Producto
Route::resource('producto','ProductoController');
Route::resource('productoSubProducto','ProductoSubProductoController'); 
Route::get('/subProductosOP/{id}','ProductoSubProductoController@subProductosOP');
Route::get('/productosOt/{id}', 'ProductoController@obtenerProductosOt');
Route::post('/cantidadProducto', 'ProductoController@obtenerCantidadPorOt');
Route::delete('productoSubProductoww/{id}','ProductoSubProductoController@destroya'); 


#SubProducto 
Route::resource('subProducto','SubProductoController');
Route::get('/subProductos/{id}', 'SubProductoController@subProductosDeProducto');

#Proceso
Route::get('/procesos/{id}','ProcesoController@obtenerProcesosPorEstacion');

#Usuario
Route::get('/trabajadores/{id}', 'UsuarioController@obtenerTrabajadoresPorEstacion');
Route::get('/obtenerGestores', 'UsuarioController@obtenerGestores');
Route::post('/usuarios/login', 'UsuarioController@buscarConRut');

#TipoMaterial
Route::resource('tipoMaterial','TipoMaterialController');
Route::get('/tipoMaterialFiltrador', 'TipoMaterialController@obtenerIdFiltrador');

#CanalVentas
Route::resource('canalVentas', 'CanalVentaController');

#OtTipo
Route::resource('otTipo','OtTipoController');

#CentroCosto
Route::resource('centroCosto','CentroCostoController');

#CategoriaOt
Route::resource('categoriaOt','CategoriaOtController');

#Cliente
Route::resource('cliente','ClienteController'); 
Route::get('obtenerCodigosCliente/{id}','ClienteProductoController@obtenerCodigosCliente');
/*  <!--@foreach ($clientes as $cliente)
            <p>{{ $cliente->nombre }}</p>
            <p>{{ $cliente->codigo }}</p>
        @endforeach--> */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
