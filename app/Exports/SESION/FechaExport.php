<?php

namespace App\Exports\SESION;

use App\SesionTrabajo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class FechaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $globalOperacion;
    public $globalCuerpo;
    function __construct($operacion,$cuerpo)
    {
        $this->globalOperacion = $operacion;
        $this->globalCuerpo = $cuerpo;
    }
    public function collection()
    {   
        error_log("a");
        $sesionCompleta = SesionTrabajo::join("detalle_sesions","sesion_trabajos.id","=","detalle_sesions.sesion_trabajo_id")
                        ->join("estacions","sesion_trabajos.estacion_id","=","estacions.id")
                        ->join("productos","detalle_sesions.producto_id","=","productos.id")
                        ->join("sub_productos","detalle_sesions.sub_producto_id","=","sub_productos.id")
                        ->join("procesos","detalle_sesions.proceso_id","=","procesos.id")
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
            if($aux1!=null){error_log("correcto1"); $newFecha1 = date("d-m-Y", strtotime($aux1));$sesion->fecha_inicio = $newFecha1;}
            if($aux2!=null){$newFecha2 = date("d-m-Y", strtotime($aux2));$sesion->fecha_termino = $newFecha2;}  
        }
        error_log("2");
        error_log("global cuerpo:");
        error_log(date("d-m-Y", strtotime($this->globalCuerpo)));
        if($this->globalOperacion==1){
            error_log("global operadion 1");
            $return = $sesionCompleta->filter(function ($item) {
                error_log('$item->fecha_inicio');
                error_log($item->fecha_inicio);
                if($item->fecha_inicio== date("d-m-Y", strtotime($this->globalCuerpo))){
                    return $item;
                }})->values();  
            return $return;            
        }
        if($this->globalOperacion==2){
                $return = $sesionCompleta->filter(function ($item) {
                    $aux1 = Carbon::parse($item->fecha_inicio);
                    $aux2 = Carbon::parse(date("d-m-Y", strtotime($this->globalCuerpo)));
                    error_log('$item->fecha_inicio');
                    error_log($aux1);
                    if($aux1->gte($aux2)){
                        return $item;
                    }})->values();   
                return $return;
        }
        if($this->globalOperacion==3){
                $return = $sesionCompleta->filter(function ($item) {
                    $aux1 = Carbon::parse($item->fecha_inicio);
                    $aux2 = Carbon::parse(date("d-m-Y", strtotime($this->globalCuerpo)));
                    if($aux1->lte($aux2)){
                        return $item;
                    }})->values(); 
                return $return;
        }
    }

    public function headings(): array
    {
        return [
            'N° SESION',
            'N° OT',
            'MATERIAL',
            'CODIGO SIOM',
            'SUB-MATERIAL',
            'PROCESO',
            'CANTIDAD',
            'N° PIEZA',
            'FECHA INICIO',
            'HORA INICIO',
            'FECHA TERMINO',
            'HORA TERMINO',
            'DURACION',
            'ESTACION',
            'OPERADOR'  
        ];
    }
}
