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
Route::group(['middleware' => 'cors'], function(){
    //aqui van todas las rutas que necesitan CORS
Route::get('/', function () {
    return view('welcome');
});

//Route::get('/homeWork', function () {
    //return view('principal');
//});

#Filtrado
Route::get('/obtenerPais', 'FiltradoController@obtenerPais');
Route::post('/cambiarPais', 'FiltradoController@cambiarPais');


#Estacion
Route::resource('estacion', 'EstacionController');
Route::post('/exportarExcelEstacion', 'EstacionController@exportarExcel');

#Nave
Route::resource('nave', 'NaveController');

#Area
Route::resource('area', 'AreaController');

#Rol
Route::resource('rol', 'RolController');

#Sesion
Route::resource('sesion', 'SesionTrabajoController');
Route::post('/sesionFinal', 'SesionTrabajoController@storeFinal');
Route::post('/exportarExcelSesion', 'SesionTrabajoController@exportarExcel');
Route::get('/test1', 'SesionTrabajoController@test');



#Ot
Route::post('/storeOt', 'OtController@store2');
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
Route::resource('usuario','UsuarioController');
Route::get('/trabajadores/{id}', 'UsuarioController@obtenerTrabajadoresPorEstacion');
Route::get('/obtenerGestores', 'UsuarioController@obtenerGestores');
Route::get('/usuariosConRol', 'UsuarioController@usuariosConRol');
Route::post('/usuarios/login', 'UsuarioController@buscarConRut');
Route::post('/exportarExcelTrabajador', 'UsuarioController@exportarExcel');
Route::post('/exportarExcelUsuario', 'UsuarioController@exportarExcelUsuario');
Route::get('/activarUsuario/{id}', 'UsuarioController@activarUsuario');
Route::get('/inactivarUsuario/{id}', 'UsuarioController@inactivarUsuario');

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
Route::resource('categoriaMaterial','CategoriaOtController');

#Cliente
Route::resource('cliente','ClienteController'); 
Route::get('obtenerCodigosCliente/{id}','ClienteProductoController@obtenerCodigosCliente');
/*  <!--@foreach ($clientes as $cliente)
            <p>{{ $cliente->nombre }}</p>
            <p>{{ $cliente->codigo }}</p>
        @endforeach--> */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
});