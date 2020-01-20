<?php

namespace App\Http\Controllers;

use App\SubProducto;
use App\ProductoSubProducto;
use Illuminate\Http\Request;

class SubProductoController extends Controller
{
    public function subProductosDeProducto($id)
    {
        $subProductos= ProductoSubProducto::where('producto_id', $id)->get();
        if(count($subProductos) == 0){
            return 0;
        }
        $subProductosCompleto = [];
        foreach($subProductos as $i){
            $sub = SubProducto::find($i->sub_producto_id);
            $subProductosCompleto[] = $sub;
        }
        return $subProductosCompleto;
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
     * @param  \App\SubProducto  $subProducto
     * @return \Illuminate\Http\Response
     */
    public function show(SubProducto $subProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubProducto  $subProducto
     * @return \Illuminate\Http\Response
     */
    public function edit(SubProducto $subProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubProducto  $subProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubProducto $subProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubProducto  $subProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubProducto $subProducto)
    {
        //
    }
}
