<template>
    <div class="margen">
        <br>
        <div class="row container">
            <div class="col-sm">
                <button type="button" @click="crearOT()" data-target="#modalCreateOt" data-toggle="modal" class="btn btn-success">Nueva OT</button>
                <div v-if="crearOtBool"> <!-- CREATE -->
                <modal-ot-create-component 
                    :key="creacionN"
                    :canales="canales"
                    :tipos="tipos"
                    :usuarios="usuarios"
                    :centros="centros"
                    :categorias="categorias"
                    :clientes="clientes"
                    :productos="productos"
                    @botonGuardarCreacionOt="guardarCreacionOt"
                    @botonGuardarCreacionMaterial="guardarCreacionMaterial">
                    </modal-ot-create-component>
                </div>
            </div>
        </div>
        <br>
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
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-1"><h6 align="center">OT</h6></div>
                <div class="col-sm-1"><h6 align="center">OT Perú</h6></div>    
                <div class="col-sm-1"><h6 align="center">Orden de Compra</h6></div>
                <div class="col-sm-2"><h6>Materiales</h6></div>
                <div class="col-sm-1"><h6 align="center">Cantidad</h6></div>
                <div class="col-sm-2"><h6 >Responsable</h6></div>
                <div class="col-sm-1"><h6 align="center">Fecha de entrega</h6></div>
                <div class="col-sm-3"><h6 align="center">Acciones</h6></div>
            
            </div>    
            <hr style="border:1px dotted gray; " />
            <div v-for="(ot,index) in otsTodas" :key="index">
                <div class="row">
                    <div class="col-sm-1">{{ot.id}}</div>
                    <div class="col-sm-1">{{ot.ot_Peru}}</div>
                    <div class="col-sm-1">{{ot.orden_compra}}</div>
                    <div class="col-sm-2">
                        <div v-for="material in ot.productos" :key="material.id">
                            <p>{{material.nombre}}</p>
                        </div>
                    </div>
                    <div class="col-sm-1">cantidades</div>
                    <div class="col-sm-2">{{ot.usuario.nombre}}</div>
                    <div class="col-sm-1">{{ot.fecha_entrega_oc}}</div>
                    <div class="col-sm-1">
                        <button type="button" data-toggle="modal" data-target="#exampleModal"  @click="masInformacion(index)" class="btn btn-info">info</button>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" data-toggle="modal" data-target="#exampleModal2" @click="editarOt(index)" class="btn btn-warning">editar</button>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-danger">eliminar</button>
                    </div>
                    <div class="col-sm"></div>
                </div>
                <hr style="border:1px dotted gray; " />
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
                categoria_ot:{nombre:""},
                creacionN:0,
                crearOtBool:false,
                clientes:[],
                canales:[],
                tipos:[],
                usuarios:[],
                centros:[],
                categorias:[]

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            crearOT(){
                //cargar 6 cosas:
                //canal de venta
                console.log("entre")
                axios
                    .get('http://localhost:8000/canalVentas/')
                    .then(response => {this.canales=response.data;})
                //ot_tipo
                axios
                    .get('http://localhost:8000/otTipo/')
                    .then(response => {this.tipos=response.data;})
                //usuario
                axios
                    .get('http://localhost:8000/obtenerGestores/')
                    .then(response => {this.usuarios=response.data;})
                //centro costo
                axios
                    .get('http://localhost:8000/centroCosto/')
                    .then(response => {this.centros=response.data;})
                //categoria
                axios
                    .get('http://localhost:8000/categoriaOt/')
                    .then(response => {this.categorias=response.data;})
                //cliente
                axios
                    .get('http://localhost:8000/cliente/')
                    .then(response => {this.clientes=response.data;})
                this.crearOtBool=true;
                //productos
                axios
                    .get('http://localhost:8000/producto/')
                    .then(response => {this.productos=response.data;})
                console.log("aqui activaré el bool");
                this.crearOtBool=true; 
            },
            guardarCreacionOt(){
                 this.$emit('botonGuardarCreacionOt');
            },
            guardarCreacionMaterial(){
                console.log("como que debo refrescar la wea"); 
            },
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
            }
        }
    }
</script>