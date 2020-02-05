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

    public function obtenerTodoOt($id)
    {
        $ot = Ot::where('id',$id)->get();
        $canal = $ot[0]->canalVenta;
        $tipo = $ot[0]->otTipo;
        $user = $ot[0]->usuario;
        $cliente = $ot[0]->cliente;
        $centro = $ot[0]->centroCosto;
        $categoria = $ot[0]->categoriaOt;
        return $ot[0];
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
        foreach($ots as $ot){
            $ot->usuario;
            $ot->productos;
        }
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
    public function ultimaPeru(){
        
        return $peru;
    }

    public function store(Request $request)
    {
        $otPeru = $request->input('otPeru');
        $orden = $request->input('orden');
        $numero = $request->input('numero');
        $guia = $request->input('guia');
        $factura = $request->input('factura');
        $fecha = $request->input('fecha');
        $tipo = $request->input('tipo');
        $categoria = $request->input('categoria');
        $cliente = $request->input('cliente');
        $canal = $request->input('canal');
        $centro = $request->input('centro');
        $responsable = $request->input('responsable');
        $seleccionadosArray = $request->input('seleccionados');
        $observacion = $request->input('observacion');

        $i = 0;
        $ultima = Ot::where('ot_Peru','!=',null )->orderBy('ot_Peru','desc')->get();
        if(!empty($ultima)){
            $i = $ultima[0]->ot_Peru;
        }

        #Para la OT
        $ot = new Ot;
        if($otPeru){
            $ot->ot_Peru = $i;
        }
        $ot->fecha_real_entrega = $fecha;
        $ot->fecha_despacho = $fecha;
        $ot->fecha_entrega_oc = $fecha;
        $ot->abierta = 1;
        $ot->recepcionada = 0;
        $ot->despachada = 0;
        $ot->fecha_recepcion = $fecha;
        $ot->orden_compra = $orden;
        $ot->numero_cotizacion = $numero;
        $ot->observacion = $observacion;
        $ot->guia_despacho = $guia;
        $ot->factura = $factura;
        error_log("1");
        $ot->canal_venta_id = $canal['id'];
        error_log("2");
        $ot->ot_tipo_id = $tipo['id'];
        error_log("3");
        $ot->usuario_id = $responsable['id'];
        $ot->centro_costo_id = $centro['id'];
        error_log("4");
        $ot->categoria_ot_id = $categoria['id'];
        error_log("5");
        $ot->cliente_id = $cliente['id'];
        error_log($ot->cliente_id);
        $ot->save();
        error_log("guarde la ot");
        #Para la OtProducto
        foreach($seleccionadosArray as $prod){
            $otProducto = new OtProducto;
            $otProducto->cantidad = $prod[1];
            $otProducto->ot_id = $ot->id;
            $otProducto->producto_id = $prod[0]['id'];
            $otProducto->save();
        }



        return "termine";
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
