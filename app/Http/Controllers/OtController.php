<?php

namespace App\Http\Controllers;

use App\Ot;
use App\OtProducto;
use App\CategoriaOt;
use App\Producto;
use App\Cliente;
use App\ClienteProducto;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OT\TodasExport;
use App\Exports\OT\NumeroOtExport;
use App\Exports\OT\FechaOcExport;
use App\Exports\OT\FechaEntregaExport;
use App\Exports\OT\PaisExport;
use App\Exports\OT\ClienteExport;
use App\Exports\OT\CodigoSiomExport;
use App\Exports\OT\ResponsableExport;
use App\Exports\OT\TipoExport;
use Carbon\Carbon;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $globalCuerpo = "111";
    public function test(){

        
        $otCompleta = Ot::join("ot_productos","ots.id","=","ot_productos.ot_id")->
                        join("productos","ot_productos.producto_id","=","productos.id")->
                        join("clientes","ots.cliente_id","=","clientes.id")->
                        join("cliente_productos","productos.id","=","cliente_productos.producto_id")->
                        join("canal_ventas","ots.canal_venta_id","=","canal_ventas.id")->
                        join("centro_costos","ots.centro_costo_id","=","centro_costos.id")->
                        //join("categoria_ots","ots.categoria_ot_id","=","categoria_ots.id")->
                        join("usuarios","ots.usuario_id","=","usuarios.id")->
                        join("ot_tipos","ots.ot_tipo_id","=","ot_tipos.id")->orderBy('ots.id')->
                        select('ots.id','ots.ot_Peru','ots.fecha_recepcion','ots.orden_compra','numero_cotizacion','clientes.nombre_cliente',
                        'ot_productos.cantidad','productos.nombre_producto','cliente_productos.codigo_cliente',
                        'productos.codigo_siom','productos.numero_plano','ot_productos.fecha_entrega_oC','ot_productos.fecha_real_entregA',
                        'ot_productos.fecha_despachO','ot_productos.guia_despacho','ot_productos.factura','canal_ventas.nombre_canal',
                        'ot_productos.estado_OT','ot_tipos.nombre_tipo','centro_costos.codigo','centro_costos.nombre_centro','ot_productos.categoria_nombre_aux',
                        'usuarios.nombre_usuario','ots.observacion')
                        ->get();
                        error_log("?");
                        
                        foreach($otCompleta as $ot){
                            $aux1 = $ot->fecha_entrega_oC;
                            //error_log($aux1);
                            $aux2 = $ot->fecha_recepcion;
                           // error_log($aux2);
                            $aux3 = $ot->fecha_real_entregA;
                            error_log($aux3);
                            $aux4 = $ot->fecha_despachO;
                            error_log($aux4);
                            if($aux1!=null){$newFecha1 = date("d-m-Y", strtotime($aux1));
                                error_log($newFecha1);$ot->fecha_entrega_oC = $newFecha1;
                            }
                            if($aux2!=null){$newFecha2 = date("d-m-Y", strtotime($aux2));$ot->fecha_recepcion = $newFecha2;}
                            if($aux3!=null){$newFecha3 = date("d-m-Y", strtotime($aux3));$ot->fecha_real_entregA = $newFecha3;} //aqui nos caemos}
                            if($aux4!=null){$newFecha4 = date("d-m-Y", strtotime($aux4));$ot->fecha_despachO = $newFecha4;}
                        }
        return $otCompleta;
    }

    public function exportarExcel(Request $request){
        $opcion = $request->input('opcion');
        $operacion = $request->input('operacion');
        $cuerpo = $request->input('cuerpo');
        $abierta = $request->input('abierta');
        $cerrada = $request->input('cerrada');

        error_log("opcion:");
        error_log($opcion);
        if($opcion=="1"){return Excel::download(new TodasExport($abierta, $cerrada),'ot-list.xlsx');}
        if($opcion=="2"){return Excel::download(new NumeroOtExport($abierta, $cerrada,$operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="3"){return Excel::download(new FechaOcExport($abierta, $cerrada,$operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="4"){return Excel::download(new FechaEntregaExport($abierta, $cerrada,$operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="5"){return Excel::download(new PaisExport($abierta, $cerrada,$cuerpo),'ot-list.xlsx');}
        if($opcion=="6"){return Excel::download(new ClienteExport($abierta, $cerrada,$cuerpo),'ot-list.xlsx');}
        if($opcion=="7"){return Excel::download(new CodigoSiomExport($abierta, $cerrada,$cuerpo),'ot-list.xlsx');}
        if($opcion=="8"){return Excel::download(new ResponsableExport($abierta, $cerrada,$cuerpo),'ot-list.xlsx');}
        if($opcion=="9"){return Excel::download(new TipoExport($abierta, $cerrada,$cuerpo),'ot-list.xlsx');}
              
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

    public function seleccionados($id){   //pal edir ocupo esta wea, debo meter las cosas nuevas
        error_log("entre a seleccionados");
        $ot = Ot::find($id);
        $seleccionados = array();
       //$combinaciones = OtProducto::where('ot_id',$id);
       $combinaciones = Ot::join("ot_productos","ots.id","=","ot_productos.ot_id")
                        ->join("cliente_productos",function($join){
                            $join->on("ots.cliente_id","=","cliente_productos.cliente_id")
                                ->on("ot_productos.producto_id","=","cliente_productos.producto_id");})
                        ->where('ots.id',$id)->get();
        error_log("combinaciones");
        foreach($combinaciones as $combi){
            $tupla = array();
            $producto = Producto::find($combi->producto_id);
            $tupla[] = $producto;
            $tupla[] = $combi->cantidad;
            $tupla[] = $combi->codigo_cliente;
            error_log($combi);
            $categoria = CategoriaOt::find($combi->categoria_id);
            error_log("despues");
            error_log($categoria);
            $tupla[] =  $categoria;
            $newFecha1 = date("Y-m-d", strtotime($combi->fecha_entrega_oc));
            error_log($newFecha1);
            $tupla[] = $newFecha1;
            error_log("1");
            $newFecha2 = date("Y-m-d", strtotime($combi->fecha_real_entrega));
            $tupla[] = $newFecha2;
            error_log("2");
            $newFecha3 = date("Y-m-d", strtotime($combi->fecha_despacho));
            $tupla[] = $newFecha3;
            error_log("3-1");
            $tupla[] = $combi->guia_despacho;
            $tupla[] = $combi->factura;
            error_log("4");
            $tupla[] = $combi->estado_OT;
            $tupla[] = $combi->recepcionada;
            error_log("5");
            $tupla[] = $combi->despachada;
            $seleccionados[] = $tupla;
        }
        return $seleccionados;
    }

    public function obtenerProductos($id){
        $allData = new Object_(); 
        $lineas = OtProducto::where('ot_id',$id)->get();
        $productos = array();
        foreach($lineas as $linea){
            $lineaAux = $linea;
            $ot = Ot::find($id);
            $clienteProd = ClienteProducto::where('producto_id',$linea->producto_id)->where('cliente_id',$ot->cliente_id)->get();
            $lineaAux->fecha_entrega_oC = date("d-m-Y", strtotime($linea->fecha_entrega_oC));
            $lineaAux->fecha_real_entregA = date("d-m-Y", strtotime($linea->fecha_real_entregA));
            $lineaAux->fecha_despachO = date("d-m-Y", strtotime($linea->fecha_despachO));
            error_log($clienteProd[0]->cliente_id);
            $lineaAux->codigo_cliente = $clienteProd[0]->codigo_cliente;
            error_log("bbb");
            $producto = Producto::find($lineaAux->producto_id);
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
                    $aux->fecha_entrega_oc =  date("d-m-Y", strtotime($asd[0]->fecha_entrega_oC));
                    $aux->categoria_id = $asd[0]->categoria_id;
                    $aux->guia_despacho=$asd[0]->guia_despacho;
                    $aux->factura=$asd[0]->factura;
                    $aux->fecha_real_entrega= date("d-m-Y", strtotime($asd[0]->fecha_real_entregA)); 
                    $aux->fecha_despacho = date("d-m-Y", strtotime($asd[0]->fecha_despachO));
                    $aux->estado_OT = $asd[0]->estado_OT;
                    $aux->recepcionada = $asd[0]->recepcionada;
                    $aux->despcachada = $asd[0]->despcachada;
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
        //$ot->abierta = 1;
        //$ot->recepcionada = 0;
        //$ot->despachada = 0;
        $ot->fecha_recepcion = $recepcion;
        $ot->orden_compra = $orden;
        $ot->numero_cotizacion = $numero;
        $ot->observacion = $observacion;
        error_log("1");
        $ot->canal_venta_id = $canal['id'];
        error_log("2");
        $ot->ot_tipo_id = $tipo['id'];
        error_log("3");
        $ot->usuario_id = $responsable['id'];
        $ot->centro_costo_id = $centro['id'];
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
            $otProducto->categoria_id = $prod[3]['id'];
            $otProducto->categoria_nombre_aux = $prod[3]['nombre_categoria'];
            $otProducto->fecha_entrega_oc = $prod[4];
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
        //$guia = $request->input('guia');
        //$factura = $request->input('factura');
        //$fecha = $request->input('fecha');
        $recepcion = $request->input('recepcion');
        $tipo = $request->input('tipo');
        //$categoria = $request->input('categoria');
        $cliente = $request->input('cliente');
        $canal = $request->input('canal');
        $centro = $request->input('centro');
        $responsable = $request->input('responsable');
        $seleccionadosArray = $request->input('seleccionados');
        $observacion = $request->input('observacion');
        //$abierta = $request->input('abierta');
        //$recepcionada = $request->input('recepcionada');
        //$despachada = $request->input('despachada');
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
        error_log("???");
        if($otPeru){
            error_log("?");
            $ot->ot_Peru = $i;
        }
        //$ot->fecha_real_entrega = $fecha;
        //$ot->fecha_despacho = $fecha;
        //$newFecha = date("d-m-Y", strtotime($fecha));
        //error_log($newFecha);
        //$ot->fecha_entrega_Oc = $newFecha;
        //$ot->abierta = 1;
        //$ot->recepcionada = 0;
        //$ot->despachada = 0;
        //$newRecepcion = date("d-m-Y", strtotime($recepcion));
        $ot->fecha_recepcion = $recepcion;
        $ot->orden_compra = $orden;
        $ot->numero_cotizacion = $numero;
        $ot->observacion = $observacion;
        //$ot->guia_despacho = $guia;
        //$ot->factura = $factura;
        error_log("1");
        $ot->canal_venta_id = $canal['id'];
        error_log("2");
        $ot->ot_tipo_id = $tipo['id'];
        error_log("3");
        $ot->usuario_id = $responsable['id'];
        $ot->centro_costo_id = $centro['id'];
        //$ot->categoria_ot_id = $categoria['id'];
        error_log("5");
        $ot->cliente_id = $cliente['id'];
        error_log($ot->cliente_id);
        //$ot->abierta = $abierta;
        //$ot->despachada = $despachada;
        //$ot->recepcionada = $recepcionada;
        $ot->save();
        error_log("guarde la ot");
        
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
            $elegido = OtProducto::where('ot_id',$ot->id)->get();
            error_log($elegido);
            if(count($elegido)==0){
                $otProducto = new OtProducto;
            }
            else{
                $otProducto = OtProducto::where('ot_id',$ot->id)->where('producto_id',$prod[0]['id'])->get();
                $otProducto = $otProducto[0];
            }
                error_log("entre");
                $otProducto->cantidad = (int)$prod[1];
                $otProducto->ot_id = $ot->id;
                $otProducto->producto_id = $prod[0]['id'];
                $otProducto->categoria_id = $prod[3]['id'];
                $otProducto->categoria_nombre_aux = $prod[3]['nombre_categoria'];
                $otProducto->guia_despacho = $prod[7];
                error_log("aaa");
                $otProducto->factura = $prod[8];
                $otProducto->fecha_entrega_oC = $prod[4];
                $otProducto->fecha_real_entregA = $prod[5];
                error_log("gggg");
                $otProducto->fecha_despachO = $prod[6];
                error_log("lll");
                $otProducto->estado_OT = $prod[9];
                error_log($otProducto->estado_OT);
                $otProducto->recepcionada = $prod[10];
                $otProducto->despachada= $prod[11];
                error_log("hhhh");
                $otProducto->save();
                error_log("guarde el otProducto");
             

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
            $clienteProd = new ClienteProducto;
            $clienteProd->cliente_id = $cliente['id'];
            $clienteProd->producto_id = $prod[0]['id'];
            $clienteProd->codigo_cliente = $prod[2];
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
