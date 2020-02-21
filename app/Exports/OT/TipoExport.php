<?php

namespace App\Exports\OT;

use App\Ot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TipoExport implements FromCollection, WithHeadings
{
    public $globalAbierta;
    public $globalCerrada;
    public $globalCuerpo;
    public $tiposArray = array();

    function __construct($abierta,$cerrada,$cuerpo)
    {
        error_log("constructor");
        $this->globalAbierta = $abierta;
        $this->globalCerrada = $cerrada;
        $this->globalCuerpo = $cuerpo;
        error_log("cuerpo:");
        error_log($this->globalCuerpo[0]['nombre_tipo']);
    }

    public function collection()
    {
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
                        'usuarios.nombre_usuario','ots.observacion','ots.abierta')
                        ->get();
                        error_log("?");
        //lo mismo con pais
        //cambiar los numeros por abierta o cerrada, pero despues
        foreach($otCompleta as $ot){
            $aux1 = $ot->fecha_entrega_oC;
            $aux2 = $ot->fecha_recepcion;
            $aux3 = $ot->fecha_real_entregA;
            $aux4 = $ot->fecha_despachO;
            if($aux1!=null){$newFecha1 = date("d-m-Y", strtotime($aux1));$ot->fecha_entrega_oC = $newFecha1;}
            if($aux2!=null){$newFecha2 = date("d-m-Y", strtotime($aux2));$ot->fecha_recepcion = $newFecha2;}
            if($aux3!=null){$newFecha3 = date("d-m-Y", strtotime($aux3));$ot->fecha_real_entregA = $newFecha3;} //aqui nos caemos}
            if($aux4!=null){$newFecha4 = date("d-m-Y", strtotime($aux4));$ot->fecha_despachO = $newFecha4;}
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

        error_log("3");
        if($this->globalAbierta && $this->globalCerrada){
            $return = $otCompleta->filter(function ($item) {
                    if(in_array($item->nombre_tipo, $this->tiposArray)){
                        error_log("true");
                        return $item;
                    }})->values(); 
                return $return;
        }
        elseif($this->globalAbierta){
            $return = $abiertas->filter(function ($item) {
                if(in_array($item->nombre_tipo, $this->tiposArray)){
                    return $item;
                }})->values(); 
            return $return;
        }
        else{
            $return = $cerradas->filter(function ($item) {
                if(in_array($item->nombre_tipo, $this->tiposArray)){
                    return $item;
                }})->values(); 
            return $return;
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
