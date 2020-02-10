<?php

namespace App\Http\Controllers;

use App\Ot;
use App\OtProducto;
use App\Producto;
use App\Cliente;
use App\ClienteProducto;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OtsExport;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function exportarExcel(){
        
        return Excel::download(new OtsExport,'ot-list.xlsx');
    }
    public function cerrarOt($id){
        $ot = Ot::find($id);
        $ot->abierta= false;
        $ot->save();
        return "CORRECTO";
    }
    public function abrirOt($id){
        $ot = Ot::find($id);
        $ot->abierta= 1;
        $ot->save();
        return "CORRECTO";
    }

    public function seleccionados($id){
        $ot = Ot::find($id);
        $seleccionados = array();
       //$combinaciones = OtProducto::where('ot_id',$id);
       $combinaciones = Ot::join("ot_productos","ots.id","=","ot_productos.ot_id")
                        ->join("cliente_productos",function($join){
                            $join->on("ots.cliente_id","=","cliente_productos.cliente_id")
                                ->on("ot_productos.producto_id","=","cliente_productos.producto_id");})
                        ->where('ots.id',$id)->get();
        
        foreach($combinaciones as $combi){
            $tupla = array();
            $producto = Producto::find($combi->producto_id);
            $tupla[] = $producto;
            $tupla[] = $combi->cantidad;
            $tupla[] = $combi->codigo_cliente;
            $seleccionados[] = $tupla;
        }
        return $seleccionados;
    }

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
        error_log("1");
        if(count($ots)>0){
            error_log("2");
            $tot = array();
            foreach($ots as $ot){
                $ot->usuario;
                $ot->cliente;
                $aaa = $ot->productos;
                $productos = array();
                foreach($aaa as $prod){
                    $aux = new Object_();
                    $aux->producto = $prod;
                    $asd = OtProducto::where('ot_id',$ot->id)
                                    ->where('producto_id',$prod->id)
                                    ->get();
                    $aux->cantidad = $asd[0]->cantidad;
                    $productos[] = $aux;
                }
                $tot[] = $productos;
                $ot->productos = 1;
                $ot->otTipo;
                $ot->canalVenta;
                $ot->centroCosto;
                $ot->categoriaOt;
            }
        }
        error_log("3");
        //$paginas = count($ots) /10;
        //$otsFinal = $ots[0]->paginate((int)$paginas+1);
        error_log("3");
        $aRetornar = array();
        $aRetornar[] = $ots;
        $aRetornar[] = $tot;
        return $aRetornar;
      
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
        $recepcion = $request->input('recepcion');
        $tipo = $request->input('tipo');
        $categoria = $request->input('categoria');
        $cliente = $request->input('cliente');
        $canal = $request->input('canal');
        $centro = $request->input('centro');
        $responsable = $request->input('responsable');
        $seleccionadosArray = $request->input('seleccionados');
        $observacion = $request->input('observacion');
        $abierta = $request->input('abierta');
        $recepcionada = $request->input('recepcionada');
        $despachada = $request->input('despachada');
        error_log("fecha");
        error_log($fecha);

        $i = 1;
        $ultima = Ot::where('ot_Peru','!=',null )->orderBy('ot_Peru','desc')->get();
        error_log($ultima);
        error_log("antes de peru");
        if(count($ultima)>0){
            error_log("entre al if");
            $i = $ultima[0]->ot_Peru + 1;
        }
    
        #Para la OT
        $ot = new Ot;
        if($otPeru){
            $ot->ot_Peru = $i;
        }
        //$ot->fecha_real_entrega = $fecha;
        //$ot->fecha_despacho = $fecha;
        $ot->fecha_entrega_oc = $fecha;
        //$ot->abierta = 1;
        //$ot->recepcionada = 0;
        //$ot->despachada = 0;
        $ot->fecha_recepcion = $recepcion;
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
        $ot->usuario_id = $responsable['usuario_id'];
        $ot->centro_costo_id = $centro['id'];
        $ot->categoria_ot_id = $categoria['id'];
        error_log("5");
        $ot->cliente_id = $cliente['id'];
        error_log($ot->cliente_id);
       // $ot->abierta = $abierta;
        //$ot->despachada = $despachada;
        //$ot->recepcionada = $recepcionada;
        $ot->save();
        error_log("guarde la ot");

        foreach($seleccionadosArray as $prod){
            $aux = ClienteProducto::where('producto_id',$prod[0]['id'])
                                    ->where('cliente_id',$cliente['id'])
                                    ->get();
            if(count($aux)>0){
                $aux[0]->delete();
            }
            $otProducto = new OtProducto;
            $otProducto->cantidad = (int)$prod[1];
            $otProducto->ot_id = $ot->id;
            $otProducto->producto_id = $prod[0]['id'];
            $otProducto->save();

            #Para producto
            error_log("pa acachar que onda");
            error_log($prod[0]['numero_plano']);
            $producto = Producto::find($prod[0]['id']);
            if($prod[0]['codigo_siom']!= ""){
                $producto->codigo_siom = $prod[0]['codigo_siom'];
            }
            if($prod[0]['numero_plano']!= ""){
                $producto->numero_plano = $prod[0]['numero_plano'];
            }
            $producto->save();

            #para cliente si es que no lo tiene
            error_log("1");
            $clienteProd = new ClienteProducto;
            $clienteProd->cliente_id = $cliente['id'];
            error_log("2");
            $clienteProd->producto_id = $prod[0]['id'];
            $clienteProd->codigo_cliente = $prod[2];
            error_log("3");
            error_log($clienteProd);
            $clienteProd->save();
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
        $otPeru = $request->input('otPeru');
        $orden = $request->input('orden');
        $numero = $request->input('numero');
        $guia = $request->input('guia');
        $factura = $request->input('factura');
        $fecha = $request->input('fecha');
        $recepcion = $request->input('recepcion');
        $tipo = $request->input('tipo');
        $categoria = $request->input('categoria');
        $cliente = $request->input('cliente');
        $canal = $request->input('canal');
        $centro = $request->input('centro');
        $responsable = $request->input('responsable');
        $seleccionadosArray = $request->input('seleccionados');
        $observacion = $request->input('observacion');
        $abierta = $request->input('abierta');
        $recepcionada = $request->input('recepcionada');
        $despachada = $request->input('despachada');
        $viejos = $request->input('viejos');
        error_log("viejos");
        error_log($viejos[0][0]['id']);

        $i = 1;
        $ultima = Ot::where('ot_Peru','!=',null )->orderBy('ot_Peru','desc')->get();
        error_log($ultima);
        error_log("antes de peru");
        if(count($ultima)>0){
            error_log("entre al if");
            $i = $ultima[0]->ot_Peru + 1;
        }
    
        #Para la OT
        error_log("la ot que me llego:");
        error_log($ot);
        $ot = Ot::find($ot->id);
        
        if($otPeru){
            $ot->ot_Peru = $i;
        }
        //$ot->fecha_real_entrega = $fecha;
        //$ot->fecha_despacho = $fecha;
        $ot->fecha_entrega_oc = $fecha;
        //$ot->abierta = 1;
        //$ot->recepcionada = 0;
        //$ot->despachada = 0;
        $ot->fecha_recepcion = $recepcion;
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
        $ot->usuario_id = $responsable['usuario_id'];
        $ot->centro_costo_id = $centro['id'];
        $ot->categoria_ot_id = $categoria['id'];
        error_log("5");
        $ot->cliente_id = $cliente['id'];
        error_log($ot->cliente_id);
        $ot->abierta = $abierta;
        $ot->despachada = $despachada;
        $ot->recepcionada = $recepcionada;
        $ot->save();
        error_log("guarde la ot");

    
        #Para la OtProducto
        $eliminadas = OtProducto::where('ot_id',$ot->id)->get();
        error_log("1");
        //return $eliminadas;
        error_log("w");
        foreach($eliminadas as $el){
            $el->delete();
            error_log("2");
        }
        

        foreach($viejos as $linea){
            $aux = ClienteProducto::where('producto_id',$linea[0]['id'])
                                    ->where('cliente_id',$cliente['id'])
                                    ->get();
                                    
            error_log("aux:");
            error_log($aux);
            if(count($aux)>0){
                $aux[0]->delete();
            }
            
        }
        foreach($seleccionadosArray as $prod){
            $otProducto = new OtProducto;
            $otProducto->cantidad = (int)$prod[1];
            $otProducto->ot_id = $ot->id;
            $otProducto->producto_id = $prod[0]['id'];
            $otProducto->save();

            #Para producto
            $producto = Producto::find($prod[0]['id']);
            if($prod[0]['codigo_siom']!= ""){
                $producto->codigo_siom = $prod[0]['codigo_siom'];
            }
            if($prod[0]['numero_plano']!= ""){
                $producto->numero_plano = $prod[0]['numero_plano'];
            }
            $producto->save();

            #para cliente si es que no lo tiene
            error_log("1");
            $clienteProd = new ClienteProducto;
            $clienteProd->cliente_id = $cliente['id'];
            error_log("2");
            $clienteProd->producto_id = $prod[0]['id'];
            $clienteProd->codigo_cliente = $prod[2];
            error_log("3");
            error_log($clienteProd);
            $clienteProd->save();
        }



        return "termine";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ot $ot)
    {
        {
            $prod = Ot::find($ot->id);
            $prod->delete();
            return "CORRECTO";
        }
    }
}
