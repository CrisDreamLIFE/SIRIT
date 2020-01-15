<?php

namespace App\Http\Controllers;

use App\Producto;
use App\OtProducto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function obtenerProductosOt($id)//id de la ot
    {
        $productos= OtProducto::where('ot_id', $id)->get();
        echo ($productos);
        if(count($productos) == 0){
            return 0;
        }
        //filtro repetidos
        $productosFiltrados = array();
        foreach($productos as $producto){
            if(!in_array($producto->producto_id, $productosFiltrados)){
                $productosFiltrados[] = $producto->producto_id;
            }
        }
        $productosCompletos = array();
        foreach($productosFiltrados as $id){
            $prod = Producto::find($id);
            $productosCompletos[] = $prod;
        }
        return $productosCompletos;
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
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
