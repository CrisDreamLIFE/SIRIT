<?php

namespace App\Http\Controllers;

use App\ClienteProducto;
use Illuminate\Http\Request;

class ClienteProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerCodigosCliente($id){
        $codigos= ClienteProducto::where('cliente_id',$id)->get();
        return $codigos;
    }

    public function obtenerClienteCodigo(Request $request){
        $cliente_id = $request->input('cliente');
        $producto_id = $request->input('producto');
        $codigo =  ClienteProducto::where('cliente_id',$cliente_id)->where('producto_id', $producto_id)->get();
        error_log("cliete;");
        error_log($cliente_id);
        error_log("producto;");
        error_log($producto_id);
        error_log("codigo;");
        error_log($codigo);
        if(count($codigo)==0){
            return 0;
        }
        else{
            return $codigo[0]->codigo_cliente;
        }
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClienteProducto  $clienteProducto
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteProducto $clienteProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClienteProducto  $clienteProducto
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteProducto $clienteProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClienteProducto  $clienteProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClienteProducto $clienteProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClienteProducto  $clienteProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteProducto $clienteProducto)
    {
        //
    }
}
