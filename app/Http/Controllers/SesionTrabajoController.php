<?php

namespace App\Http\Controllers;

use App\SesionTrabajo;
use App\OtSesionTrabajo;
use App\ProcesoSesionTrabajo;
use App\ProductoSesionTrabajo;
use App\SesionTrabajoSubProducto;
use App\DetalleSesion;
use App\SesionTrabajoUsuario;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SESION\TodasExport;
use App\Exports\SESION\NumeroOtExport;
use App\Exports\SESION\FechaExport;
use App\Exports\SESION\AreaExport;
use App\Exports\SESION\EstacionExport;
use App\Exports\SESION\NaveExport;
use App\Exports\SESION\EnProcesoExport;
use App\Exports\SESION\CodigoExport;

class SesionTrabajoController extends Controller
{
    public function test(){
        $sesionCompleta = SesionTrabajo::join("detalle_sesions","sesion_trabajos.id","=","detalle_sesions.sesion_trabajo_id")
                        ->join("estacions","sesion_trabajos.estacion_id","=","estacions.id")
                        ->join("productos","detalle_sesions.producto_id","=","productos.id")
                        ->join("sub_productos","detalle_sesions.sub_producto_id","=","sub_productos.id")
                        ->join("procesos","detalle_sesions.proceso_id","=","procesos.id")
                        //->join("areas","estacions.area_id","=","areas.id")
                        ->orderBy('sesion_trabajos.id','DESC')
                        ->select('detalle_sesions.sesion_trabajo_id','detalle_sesions.ot_id','productos.nombre_producto','productos.codigo_siom',
                        'sub_productos.nombre_sub_producto','procesos.nombre_proceso','detalle_sesions.cantidad',
                        'detalle_sesions.numero_pieza','sesion_trabajos.fecha_inicio','sesion_trabajos.hora_inicio',
                        'sesion_trabajos.fecha_termino','sesion_trabajos.hora_termino','sesion_trabajos.duracion',
                        'estacions.codigo','detalle_sesions.operador')
                        ->get();

                        error_log("1");
        foreach($sesionCompleta as $sesion){
            $aux1 = $sesion->fecha_inicio;
            $aux2 = $sesion->fecha_termino;
            if($aux1!=null){$newFecha1 = date("d-m-Y", strtotime($aux1));$sesion->fecha_inicio = $newFecha1;}
            if($aux2!=null){$newFecha2 = date("d-m-Y", strtotime($aux2));$sesion->fecha_termino = $newFecha2;}
        }
            
            return $sesionCompleta;
    }


    public function exportarExcel(Request $request){
        $opcion = $request->input('opcion');
        $operacion = $request->input('operacion');
        $cuerpo = $request->input('cuerpo');
        $abierta = $request->input('abierta');
        $cerrada = $request->input('cerrada');

        error_log("opcion:");
        error_log($opcion);
        if($opcion=="1"){error_log("opcion de la 1o"); return Excel::download(new TodasExport(),'ot-list.xlsx');}
        if($opcion=="2"){error_log("opcion de la 2"); return Excel::download(new NumeroOtExport($operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="3"){error_log("opcion de la 3"); return Excel::download(new FechaExport($operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="4"){error_log("opcion de la 4"); return Excel::download(new AreaExport($operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="5"){error_log("opcion de la 5"); return Excel::download(new EstacionExport($operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="6"){error_log("opcion de la 6"); return Excel::download(new NaveExport($operacion,$cuerpo),'ot-list.xlsx');}
        if($opcion=="7"){error_log("opcion de la 7"); return Excel::download(new EnProcesoExport(),'ot-list.xlsx');}     
        if($opcion=="8"){error_log("opcion de la 8"); return Excel::download(new CodigoExport($operacion,$cuerpo),'ot-list.xlsx');}
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

    public function storeFinal(Request $request)
    {
        $sesion_id = $request->input('id_sesion');
        $otProductoArray = $request->input('otProducto');
        $procesosIdArray = $request->input('procesos');
        $piezasArray = $request->input('piezas');
        $cantidadProcesosArray = $request->input('cantidadProcesos');
        $ots = $request->input('ots');
        $fechaActual = Carbon::now(); 

        #buscamos la sesion:
        $sesion = SesionTrabajo::find($sesion_id);

        #guardamos sus datos faltantes:
        $sesion->fecha_termino = $fechaActual;
        $sesion->hora_termino = $fechaActual;
        $horaInicial = $sesion->created_at;
        $diferencia = $horaInicial->diffInMinutes($fechaActual);
        error_log("diferencia:");
        error_log($diferencia);
        $dias = $diferencia*0.000694444444;
        //$sesion->duracion = $diferencia->format('días: %a, horas: %h, minutos: %i, segundos: %s');
        $sesion->duracion = $dias;
        $sesion->save();
        error_log("guarde la sesion");

        //poner que la hora sea como HTOT/24, ahora bien, deberia quizas obtner los minutos
        //probar en Tinker si un trabajo de media hora me marco 0.5 horas.

        #OT-SESION  
        foreach($ots as $ot ){
            error_log("1");
            $otSesion = new OtSesionTrabajo;
            $otSesion->ot_id = $ot;
            $otSesion->sesion_trabajo_id = $sesion_id;
            $otSesion->save();
            error_log("guarde la ot-sesion");
        }
    
        #PRODUCTO-SESION  SUBPRODUCTO-SESION  
        foreach($otProductoArray as $linea ){
            $proSesion = new ProductoSesionTrabajo;
            $proSesion->producto_id = $linea[1]['id'];
            $proSesion->sesion_trabajo_id = $sesion_id;
            $proSesion->save();
            error_log("guarde la producto-sesion");
            foreach($linea[2] as $sub){
                $subSesion = new SesionTrabajoSubProducto;
                $subSesion->sub_producto_id = $sub['id'];
                $subSesion->sesion_trabajo_id = $sesion_id;
                $subSesion->save();
                error_log("guarde la subprod-sesion");
            }
        }

        #PROCESO-SESION
        foreach($procesosIdArray as $proceso ){
            $procesoSesion = new ProcesoSesionTrabajo;
            $procesoSesion->proceso_id = $proceso;
            $procesoSesion->sesion_trabajo_id = $sesion_id;
            $procesoSesion->save();
            error_log("guarde proceso-sesion");
        }

        
        #guardamos las tablas intermedias: son como 1000 :v
        #detalleSesion:
        $i=0;
        foreach($otProductoArray as $linea ){
            $j=0;
            error_log("a");
            foreach($linea[2] as $sub ){
                $k=0;
                error_log("b");
                foreach($procesosIdArray as $proceso ){
                    error_log("largo de procesosarray:");
                    error_log(count($procesosIdArray));
                    $nuevo = DetalleSesion::where("sesion_trabajo_id",$sesion->id)
                            ->where("ot_id", $linea[0]['id'])
                            ->where("producto_id",$linea[1]['id'])
                            ->where("sub_producto_id",$sub['id'])
                            ->where("proceso_id",$proceso)->get();   //new DetalleSesion;  //find
                    error_log($nuevo);
                            error_log($linea[0]['id']);
                    error_log($linea[1]['id']);
                    error_log($sub['id']);
                    error_log($proceso);
                            /*$nuevo->sesion_trabajo_id = $sesion->id;
                    $nuevo->ot_id = $linea[0]['id']; 
                    $nuevo->producto_id = $linea[1]['id'];
                    $nuevo->sub_producto_id = $sub['id'];*/  //creo que es ele objeto, en vola es el id nomas
                    error_log("d");
                    error_log("tipo de sub");
                    error_log($sub['tipo_material_id']);
                    //error_log($piezasArray[0][0][0]['nombre']);
                    if($sub['tipo_material_id']==1){
                        $nombreAux = "";
                        $l = 1;
                        foreach($piezasArray[$i][$j][$k] as $obj){
                            if($l< count($piezasArray[$i][$j][$k])){
                                $nombreAux = $nombreAux . $obj['nombre'] . ', '; 
                            }
                            else {
                                $nombreAux = $nombreAux . $obj['nombre']; 
                            }
                            $l = $l + 1;
                        }
                        error_log("sdfugu");
                        error_log($nombreAux);
                        $nuevo[0]->numero_pieza = $nombreAux;
                    }
                    error_log("f");
                    error_log("$proceso");
                   // $nuevo->proceso_id = $proceso;
                    error_log($cantidadProcesosArray[0][0][0]);
                    error_log($i);
                    error_log($j);
                    error_log($k);
                    $nuevo[0]->cantidad = intval($cantidadProcesosArray[$i][$j][$k]);
                    error_log("g");
                    error_log($nuevo[0]->cantidad);
                    //aqui meteremos el codigo para la nueva colkumna de los operadores:
                   // $usuarios = SesionTrabajoUsuario::where("sesion_trabajo_id",$sesion->id)->get();
                   /* $strAux="";
                    $m = 1;
                    foreach($usuarios as $usu){
                        $usuario = Usuario::find($usu->usuario_id);
                        if($m ==1){
                            $strAux = $strAux . $usuario->nombre_usuario;
                        }
                        else{
                            $strAux = $strAux . ", ". $usuario->nombre_usuario;
                        }
                        $m = $m + 1;
                    }
                    $nuevo->operador = $strAux;*/
                    $nuevo[0]->save();
                    error_log("guarde detalle");
                    $k=$k+1;
                }
                $j=$j+1;
            }
            $i=$i+1;
        }
        return "CORRECTO";
    }

    public function store(Request $request)
    {
        $estacion_id = $request->input('id_estacion');
        $trabajadoresArray = $request->input('trabajadores');
        $otProductoArray = $request->input('otProducto');
        $procesosIdArray = $request->input('procesos');
        $fechaActual = Carbon::now();   

        #creamos la sesion
        $sesion = new SesionTrabajo;
         
        $sesion->estacion_id = $estacion_id;
        $sesion->fecha_inicio = $fechaActual;
        $sesion->hora_inicio = $fechaActual;
        $sesion->save(); 

        #creamos la sesion-usuario
        foreach($trabajadoresArray as $trabajador ){
            $nuevo = new SesionTrabajoUsuario;
            $nuevo->usuario_id = $trabajador['id']; //aqui se cae
            $nuevo->sesion_trabajo_id = $sesion->id;
            $nuevo->save();
        }

        $i=0;
        foreach($otProductoArray as $linea ){
            $j=0;
            error_log("a");
            foreach($linea[2] as $sub ){
                $k=0;
                error_log("b");
                foreach($procesosIdArray as $proceso ){
                    error_log("largo de procesosarray:");
                    error_log(count($procesosIdArray));
                    $nuevo = new DetalleSesion;
                    $nuevo->sesion_trabajo_id = $sesion->id;
                    $nuevo->ot_id = $linea[0]['id']; 
                    $nuevo->producto_id = $linea[1]['id'];
                    $nuevo->sub_producto_id = $sub['id'];  //creo que es ele objeto, en vola es el id nomas
                    error_log("f");
                    error_log("$proceso");
                    $nuevo->proceso_id = $proceso;
                    
                    //aqui meteremos el codigo para la nueva colkumna de los operadores:
                    $usuarios = SesionTrabajoUsuario::where("sesion_trabajo_id",$sesion->id)->get();
                    $strAux="";
                    $m = 1;
                    foreach($usuarios as $usu){
                        $usuario = Usuario::find($usu->usuario_id);
                        if($m ==1){
                            $strAux = $strAux . $usuario->nombre_usuario;
                        }
                        else{
                            $strAux = $strAux . ", ". $usuario->nombre_usuario;
                        }
                        $m = $m + 1;
                    }
                    $nuevo->operador = $strAux;
                    $nuevo->save();
                    error_log("guarde detalle");
                    $k=$k+1;
                }
                $j=$j+1;
            }
            $i=$i+1;
        }

        return $sesion->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SesionTrabajo $sesionTrabajo)
    {
        //
    }
}
