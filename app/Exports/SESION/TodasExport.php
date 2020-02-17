<?php

namespace App\Exports\SESION;

use App\SesionTrabajo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TodasExport implements FromCollection, WithHeadings
{

    public $globalAbierta;
    public $globalCerrada;
    function __construct($abierta,$cerrada)
    {
        error_log("constructor");
        $this->globalAbierta = $abierta;
        $this->globalCerrada = $cerrada;
    }

    public function collection()
    {
        $otCompleta = Ot::join("ot_productos","ots.id","=","ot_productos.ot_id")->
                        join("productos","ot_productos.producto_id","=","productos.id")->
                        join("clientes","ots.cliente_id","=","clientes.id")->
                        join("cliente_productos","productos.id","=","cliente_productos.producto_id")->
                        join("canal_ventas","ots.canal_venta_id","=","canal_ventas.id")->
                        join("centro_costos","ots.centro_costo_id","=","centro_costos.id")->
                        join("categoria_ots","ots.categoria_ot_id","=","categoria_ots.id")->
                        join("usuarios","ots.usuario_id","=","usuarios.id")->
                        join("ot_tipos","ots.ot_tipo_id","=","ot_tipos.id")->orderBy('ots.id')->
                        select('ots.id','ots.ot_Peru','ots.fecha_recepcion','ots.orden_compra','numero_cotizacion','clientes.nombre_cliente',
                        'ot_productos.cantidad','productos.nombre_producto','cliente_productos.codigo_cliente',
                        'productos.codigo_siom','productos.numero_plano','ots.fecha_entrega_Oc','ots.fecha_real_entregA',
                        'ots.fecha_despacho','ots.guia_despacho','ots.factura','canal_ventas.nombre_canal',
                        'ots.abierta','ot_tipos.nombre_tipo','centro_costos.codigo','centro_costos.nombre_centro','categoria_ots.nombre_categoria',
                        'usuarios.nombre_usuario','ots.observacion')
                        ->get();
        //lo mismo con pais
        //cambiar los numeros por abierta o cerrada, pero despues
        foreach($otCompleta as $ot){
            $aux1 = $ot->fecha_entrega_Oc;
            $aux2 = $ot->fecha_recepcion;
            $aux3 = $ot->fecha_real_entregA;
            $aux4 = $ot->fecha_despacho;
            if($aux1!=null){$newFecha1 = date("d-m-Y", strtotime($aux1));$ot->fecha_entrega_Oc = $newFecha1;}
            if($aux2!=null){$newFecha2 = date("d-m-Y", strtotime($aux2));$ot->fecha_recepcion = $newFecha2;}
            if($aux3!=null){$newFecha3 = date("d-m-Y", strtotime($aux3));$ot->fecha_real_entregA = $newFecha3;} //aqui nos caemos}
            if($aux4!=null){$newFecha4 = date("d-m-Y", strtotime($aux4));$ot->fecha_despacho = $newFecha4;}

            if($ot->abierta){
                $ot->abierta = "ABIERTA";
            }
            else{
                $ot->abierta = "CERRADA";
            }
        }
        $cerradas = $otCompleta->filter(function ($item) {
            error_log($item->abierta);
            if($item->abierta=="CERRADA"){
                return $item;
            }  
        })->values();
        $abiertas = $otCompleta->filter(function ($item) {
            if($item->abierta== "ABIERTA"){
                return $item;
            }  
        })->values();
        if($this->globalAbierta && $this->globalCerrada){
            error_log("z");
            error_log($otCompleta[0]->fecha_entrega_Oc);
            return $otCompleta;
        }
        elseif($this->globalAbierta){
            error_log("x");
           //return Ot::where('abierta',1)->get();
           return $abiertas;
        }
        else{
            error_log("c");
            //return Ot::where('abierta',0)->get();
            return $cerradas;
        }
    }

    public function headings(): array
    {
        return [
            'N° OT CHILE',
            'N° OT PERU',
            'FECHA RECEPCION OT',
            'ORDEN DE COMPRA',
            'N° COTIZACION',
            'NOMBRE CLIENTE',
            'CANTIDAD',
            'DESCRIPCION',
            'CODIGO CLIENTE',
            'CODIGO SIOM',
            'N° PLANO',
            'FECHA ENTREGA OC',
            'FECHA REAL ENTREGA',
            'FECHA DESPACHO',
            'GUIA DE DESPACHO',
            'FACTURA',
            'CV',
            'ESTADO OT',
            'TIPO DE OT',
            'CODIGO CENTRO DE COSTOS',
            'CENTRO DE COSTOS',
            'CATEGORIA',
            'RESPONSABLE',
            'OBSERVACION'
        ];
    }
}
