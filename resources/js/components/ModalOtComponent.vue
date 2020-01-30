<template>
<div>
    <div  class="modal " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">OT: {{ot.id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col"><b >OT Perú:</b> 
                                        <span style="padding-left:30px;" v-if="ot.ot_peru==null">N.A</span><span style="padding-left:5px;" v-else>{{ot.ot_peru}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Fecha Recepción:</b> <span style="padding-left:30px;">{{ot.fecha_recepcion}}</span></div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Orden de Compra:</b> 
                                        <span style="padding-left:30px;" v-if="ot.orden_compra==null">N.A</span><span style="padding-left:30px;" v-else>{{ot.orden_compra}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Numero Cotización: </b>
                                        <span style="padding-left:30px;" v-if="ot.numero_cotizacion==null">N.A</span><span style="padding-left:30px;" v-else>{{ot.numero_cotizacion}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Fecha Entrega OC: </b><span style="padding-left:30px;">{{ot.fecha_entrega_oc}}</span> </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Fecha Real Entrega:</b>
                                        <span style="padding-left:30px;" v-if="ot.fecha_real_entrega==null">N.A</span><span v-else>{{ot.fecha_real_entrega}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Fecha Despacho:</b>
                                        <span style="padding-left:30px;" v-if="ot.fecha_despacho==null">N.A</span><span v-else>{{ot.fecha_despacho}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Guía Despacho:</b>
                                        <span style="padding-left:30px;" v-if="ot.guia_despacho==null">N.A</span><span v-else>{{ot.guia_despacho}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Factura:</b>
                                        <span style="padding-left:30px;" v-if="ot.factura==null">N.A</span><span v-else>{{ot.factura}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Abierta:</b>
                                        <span style="padding-left:30px;" v-if="ot.abierta==1">Si</span><span v-else>No</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Recepcionada:</b>
                                        <span style="padding-left:30px;" v-if="ot.recepcionada==1">Si</span><span v-else>No</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Despachada:</b>
                                        <span style="padding-left:30px;" v-if="ot.despachada==1">Si</span><span v-else>No</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Cliente:</b>
                                        <span style="padding-left:30px;" >{{cliente.nombre}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Canal de Venta:</b>
                                        <span style="padding-left:30px;" >{{canal_venta.nombre}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Tipo de OT:</b>
                                        <span style="padding-left:30px;" >{{ot_tipo.nombre}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Responsable:</b>
                                        <span style="padding-left:30px;" >{{usuario.nombre}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Centro de Costos:</b>
                                        <span style="padding-left:30px;" >{{centro_costo.nombre}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><b>Categoría OT:</b>
                                        <span style="padding-left:30px;" >{{categoria_ot.nombre}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row"><h4>Productos</h4></div>
                                            <div v-for="(producto,indexP) in productos" :key="indexP">
                                                <div class="row">
                                                    {{producto.nombre}} 
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="row"><h4>Cantidad</h4></div>
                                        
                                            <div v-for="(cantidad,indexC) in cantidadXProducto" :key="indexC">
                                                <div class="row">
                                                    {{cantidad.cantidad}} 
                                                </div>   
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
                </div>
    </div>
</template>

<script>
    export default {
        props: ['ot','centro_costo','cliente','productos','cantidadXProducto','cliente','canal_venta','ot_tipo','usuario','categoria_ot'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
