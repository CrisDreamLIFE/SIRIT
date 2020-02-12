<?php

namespace App\Exports\OT;

use App\Ot;
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
                        join("usuarios","ots.usuario_id","=","usuarios.id")->orderBy('ots.id')->
                        select('ots.id','ots.ot_Peru','ots.fecha_recepcion','ots.orden_compra','numero_cotizacion','clientes.nombre_cliente',
                        'ot_productos.cantidad','productos.nombre_producto','cliente_productos.codigo_cliente',
                        'productos.codigo_siom','productos.numero_plano','ots.fecha_entrega_oc','ots.fecha_real_entrega',
                        'ots.fecha_despacho','ots.guia_despacho','ots.factura','canal_ventas.nombre_canal',
                        'ots.abierta','centro_costos.nombre_centro','categoria_ots.nombre_categoria','usuarios.nombre_usuario')
                        ->get();
        //lo mismo con pais
        //cambiar los numeros por abierta o cerrada, pero despues
        if($this->globalAbierta && $this->globalCerrada){
            error_log("z");
            return $otCompleta;
        }
        elseif($this->globalAbierta){
            error_log("x");
            return Ot::where('abierta',1)->get();
        }
        else{
            error_log("c");
            return Ot::where('abierta',0)->get();
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
            'CENTRO DE COSTOS',
            'CATEGORIA',
            'RESPONSABLE'
        ];
    }
}
