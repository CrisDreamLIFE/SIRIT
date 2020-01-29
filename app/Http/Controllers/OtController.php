<?php

namespace App\Http\Controllers;

use App\Ot;
use App\OtProducto;
use App\Producto;
use App\Cliente;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function obtenerProductos($id){
        $allData = new Object_(); 
        $lineas = OtProducto::where('ot_id',$id)->get();
        $productos = array();
        foreach($lineas as $linea){
            $producto = Producto::find($linea->producto_id);
            $productos[] = $producto;
        }
        $allData->productos = $productos;
        $allData->cantidades = $lineas;

        $allData = json_encode($allData);
        return $allData;
    }

    public function obtenerCanalVentaOt($id)
    {
        $ot = Ot::where('id',$id)->get();
        $canal = $ot[0]->canalVenta;
        return $canal;
    }

    public function obtenerTipoOt($id)
    {
        $ot = Ot::where('id',$id)->get();
        $tipo = $ot[0]->otTipo;
        return $tipo;
    }

    public function obtenerResponsableOt($id)
    {
        $ot = Ot::where('id',$id)->get();
        $user = $ot[0]->usuario;
        return $user;
    }

    public function obtenerClienteOt($id)
    {
        $ot = Ot::where('id',$id)->get();
        $cliente = $ot[0]->cliente;
        return $cliente;
    }

    public function obtenerOtAbierta()
    {
        $ots = Ot::where('abierta',1)->get();
        return $ots;
    }

    public function index()
    {
        $ots = Ot::orderBy('id','desc')->get();
        $paginas = count($ots) /10;
        $otsFinal = $ots[0]->paginate((int)$paginas+1);
        error_log("3");
        return $ots;
      
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
     * @param  \App\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function show(Ot $ot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function edit(Ot $ot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ot $ot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ot $ot)
    {
        //
    }
}
