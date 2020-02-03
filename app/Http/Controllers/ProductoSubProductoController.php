<?php

namespace App\Http\Controllers;

use App\ProductoSubProducto;
use Illuminate\Http\Request;

class ProductoSubProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subProductosOP($id)
    {
        $asociaciones = ProductoSubProducto::where('producto_id',$id)->get();
        return $asociaciones;
    }
    public function index()
    {
        $todo = ProductoSubProducto::all();
        return $todo;
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
        $asociacionesArray = $request->input('asociaciones');

        foreach($asociacionesArray as $linea ){
            $nuevo = new ProductoSubProducto;
            $nuevo->producto_id = $linea[0];
            $nuevo->sub_producto_id = $linea[1];

            $nuevo->save();
        }
        return "CORRECTO";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductoSubProducto  $productoSubProducto
     * @return \Illuminate\Http\Response
     */
    public function show(ProductoSubProducto $productoSubProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductoSubProducto  $productoSubProducto
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductoSubProducto $productoSubProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductoSubProducto  $productoSubProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductoSubProducto $productoSubProducto)
    {
        
        /*$subProductosArray = $request->input('subProductos');
        error_log("producto id:");
        error_log($producto_id);
        $asociaciones = ProductoSubProducto::where('producto_id',$producto_id)->get();
        error_log("dsfsdf");
        foreach($asociaciones as $asociacion ){
            $estoy = 0;
            error_log("revisare lso sbus productos");
            foreach($subProductosArray as $sub){
                if($asociacion->sub_producto_id == $sub->id){
                    $estoy =1;
                    error_log($sub->id);
                } 
            }
            if($estoy == 0){
                $elimado = ProductoSubProducto::where('producto_id',$producto_id)
                                            ->wheere('sub_producto_id',$asociacion->sub_producto_id)
                                            ->get();
                $eliminado[0]->delete();
            }   
        }*/
        return "TERMINADO";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductoSubProducto  $productoSubProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoSubProducto $productoSubProducto)
    {
        error_log("asdsad");
        $producto_id = $productoSubProducto; //este es el producto
        $producto_id->delete();
        return "ELIMINADO";
    }

    public function destroya($productoSubProducto)
    {
        error_log("asdsad");
        error_log($productoSubProducto);
        $producto_id = ProductoSubProducto::find($productoSubProducto);
        error_log($producto_id);
        $producto_id->delete();
        return "ELIMINADO";
    }
}
