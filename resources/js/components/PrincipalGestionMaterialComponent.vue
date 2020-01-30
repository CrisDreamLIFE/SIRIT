<template>
    <div class="container">
        <div> <!--v-if="masInformacionBool"><!-modal SHOW
            <modal-ot-component>
            </modal-ot-component> -->
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-2"><h3>Nombre</h3></div>
                <div class="col-sm-2"><h3>Código Siom</h3></div>    
                <div class="col-sm-2"><h3>Número de Plano</h3></div>
                <div class="col-sm-2"><h3>Tipo de Material</h3></div>
                <div class="col-sm-3"><h3>Descripción</h3></div>
                <div class="col-sm"></div>   
            </div>    
            <div v-for="(producto,index) in productos" :key="index">
                <div class="row">
                    <div class="col-sm-2">{{producto.nombre}}</div>
                    <div class="col-sm-2">{{producto.codigo_siom}}</div>
                    <div class="col-sm-2">{{producto.numero_plano}}</div>
                    <div class="col-sm-2"><span v-if="producto.tipo_material_id==1">Pieza</span><span v-else>Lote</span></div>
                    <div class="col-sm-3">{{producto.descripcion}}</div>
                    <div class="col-sm-1">
                        <div class="row">
                           
                                <button type="button" data-toggle="modal" data-target="#exampleModal2" @click="editarOt(index)" class="btn btn-warning">E</button>
                               
                                <button type="button" class="btn btn-danger">D</button>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</template>

<script>
    export default {
        props: ['productos'], 
        data(){
            return {
              /*  masInformacionBool: false,
                indexOt:null,
                productos:[],
                cantidadXProducto:[],
                cliente:{nombre:""},
                canal_venta:{nombre:""},
                ot_tipo:{nombre:""},
                usuario:{nombre:""},
                centro_costo:{nombre:""},
                categoria_ot:{nombre:""}*/
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
           /* masInformacion(index){
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
                //abrir su modal
            }*/
        } 
    }
</script>