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
        $subproductos = SubProducto::all();
        return $subproductos;
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
        $nombreSend = $request->input('nombre');
        $descripcionSend = $request->input('descripcion');
        $tipoIdSend = $request->input('tipoMaterial');
        error_log($nombreSend);
        #creamos el nuevo producto
        $subproducto = new SubProducto;
        error_log("2");
        #asigamos los atributos al producto
        $subproducto->nombre_sub_producto = $nombreSend;
        $subproducto->descripcion = $descripcionSend;
        error_log("3");
        $subproducto->tipo_material_id = $tipoIdSend;
        error_log("4");
        #guardamos el producto
        $subproducto->save();
        error_log("5");
        return 'CORRECTO';
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
        $nombreSend = $request->input('nombre');
        $descripcionSend = $request->input('descripcion');
        $tipoIdSend = $request->input('tipoMaterial');
        #obtenemos el producto
        $subproducto = SubProducto::find($subProducto->id);
        #$producto = $producto[0];
        #editamos el producto
        $subproducto->nombre_sub_producto = $nombreSend;
        $subproducto->descripcion = $descripcionSend;
        $subproducto->tipo_material_id = $tipoIdSend;
        #guardamos el producto
        $subproducto->save();
        return 'CORRECTO';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubProducto  $subProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubProducto $subProducto)
    {
        $prod = SubProducto::find($subProducto->id);
        $prod->delete();
        return "CORRECTO";
    }
    public function cerrarSubProducto($id){
        $ot = SubProducto::find($id);
        $ot->activo= false;
        $ot->save();
        return "CORRECTO";
    }
    public function abrirSubProducto($id){
        $ot = SubProducto::find($id);
        $ot->activo= true;
        $ot->save();
        return "CORRECTO";
    }
}
