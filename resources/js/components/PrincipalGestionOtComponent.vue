<template>
    <div class="container">
        <div v-if="masInformacionBool"><!--modal SHOW -->
            <modal-ot-component
            :ot="otsTodas[indexOt]"
            :productos="productos"
            :cantidadXProducto="cantidadXProducto"
            :cliente="cliente"
            :canal_venta="canal_venta"
            :ot_tipo="ot_tipo"
            :usuario="usuario"
            :categoria_ot="categoria_ot"
            :centro_costo="centro_costo"></modal-ot-component>
        </div>
        <br>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm"><h5>OT</h5></div>
                <div class="col-sm"><h5>OT Perú</h5></div>    
                <div class="col-sm"><h5>Orden de Compra</h5></div>
                <div class="col-sm-2"><h5>Materiales</h5></div>
                <div class="col-sm"><h5>Cantidad</h5></div>
                <div class="col-sm-2"><h5>Responsable</h5></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            
            </div>    
            <hr style="border:1px dotted gray; " />
            <div v-for="(ot,index) in otsTodas" :key="index">
                <div class="row">
                    <div class="col-sm">{{ot.id}}</div>
                    <div class="col-sm">{{ot.ot_Peru}}""</div>
                    <div class="col-sm">{{ot.orden_compra}}</div>
                    <div class="col-sm-2">materiales</div>
                    <div class="col-sm">cantidades</div>
                    <div class="col-sm-2">{{ot.usuario.nombre}}</div>
                    <div class="col-sm">
                        <button type="button" data-toggle="modal" data-target="#exampleModal"  @click="masInformacion(index)" class="btn btn-info">informacion</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" data-toggle="modal" data-target="#exampleModal2" @click="editarOt(index)" class="btn btn-warning">editar</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-danger">eliminar</button>
                    </div>
                    <div class="col-sm"></div>
                </div>
            </div>
        </div>   
    </div>
</template>

<script>
    export default {
        props: ['otsTodas'], 
        data(){
            return {
                masInformacionBool: false,
                indexOt:null,
                productos:[],
                cantidadXProducto:[],
                cliente:{nombre:""},
                canal_venta:{nombre:""},
                ot_tipo:{nombre:""},
                usuario:{nombre:""},
                centro_costo:{nombre:""},
                categoria_ot:{nombre:""}
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            masInformacion(index){
                console.log("mostare el modal")
                this.indexOt=index;
                 axios
                        .get('http://localhost:8000/productosYCantidadOt/'+this.otsTodas[index].id)
                        .then(response => {
                            console.log(response)
                            this.productos=response.data.productos;
                            this.cantidadXProducto=response.data.cantidades;
                                axios
                                .get('http://localhost:8000/obtenerTodoOt/'+this.otsTodas[index].id)
                                .then(response => {
                                    console.log("ds")
                                    console.log(response.data.usuario);
                                    this.cliente=response.data.cliente;
                                    this.canal_venta=response.data.canal_venta;
                                    this.ot_tipo=response.data.ot_tipo;
                                    this.usuario=response.data.usuario;
                                    this.centro_costo=response.data.centro_costo;
                                    this.categoria_ot=response.data.categoria_ot;
                                }) 
                            })
                
                
                this.masInformacionBool=true;
                //hacer todos los get de la ot (cliente por ejempplo)
                //Productos:
                /*
                //Cliente
                axios
                    .get('http://localhost:8000/obtenerClienteOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.cliente =response.data;
                        
                        })
                //CanalVenta
                axios
                    .get('http://localhost:8000/obtenerCanalOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.canalVenta =response.data;
                        
                        })
                //TIPO OT
                axios
                    .get('http://localhost:8000/obtenerTipoOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.tipoOt =response.data;
                        })
                axios
                    .get('http://localhost:8000/obtenerResponsableOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.responsable =response.data;
                        })
                    
                //////////////////////////////////////////////////////// 
                //abrir su modal*/
            }
        }
    }
</script>