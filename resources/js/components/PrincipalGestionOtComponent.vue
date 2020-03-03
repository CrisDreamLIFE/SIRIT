<template>
    <div class="margen">
        <br>
        <div class="row container">
            <div class="col-sm-2"><!--colorBoton-->
                <button type="button" v-on:click="volverMenu" class="btn btn-secondary  btn-block colorBoton">Atrás</button>
            </div>
        </div>
        <br>
        <div class="row container">
            <div class="col-sm-4">
                <button type="button" @click="crearOT()" data-target="#modalCreateOt" data-toggle="modal" class="btn btn-success">Nueva OT</button>
            </div>
            <div class="com-sm-6">
                <div class="row">
                    <div class="col-sm">
                        <input id="7" class="form-control form-control-lg form-control-borderless" placeholder="N° OT" type="search" v-model="searchOT" @input="onChangueOT"/>
                    </div>
                    <!--end of col-->
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <input class="form-check-input" :value="true" :unchecked-value="true" v-model="abierta" id="abierta" type="checkbox">
                        <label style="font-size:18px" for = "abierta">{{'   Abiertas'}}</label> 
                    </div>
                 </div>    
            </div>
        </div>
        <br>
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
                <div v-if="editarOtBool"> <!-- EDIT -->
                    <modal-ot-edit-component
                    :key="edicionN"
                    :otSeleccionada="otSeleccionada"
                    :canales="canales"
                    :tipos="tipos"
                    :usuarios="usuarios"
                    :centros="centros"
                    :categorias="categorias"
                    :clientes="clientes"
                    :productos="productos"
                    :seleccionados="seleccionados"
                    :viejos="viejos"
                    @botonGuardarEdicionOt="guardarEdicionOt"
                    :peru="peru">
                    </modal-ot-edit-component> 
                </div>
        <div v-if="masInformacionBool"><!--modal SHOW -->
            <modal-ot-component
            :ot="otsTodas[0][indexOt]"
            :productos="productos"
            :cantidadXProducto="cantidadXProducto"
            :cliente="cliente"
            :canal_venta="canal_venta"
            :ot_tipo="ot_tipo"
            :usuario="usuario"
            :categoria_ot="categoria_ot"
            :centro_costo="centro_costo"
            ></modal-ot-component>
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-1"><h6 align="center">OT</h6></div>
                <div class="col-sm-1"><h6 align="center">OT Perú</h6></div>    
                <div class="col-sm-1"><h6 align="center">Estado</h6></div>
                <div class="col-sm-2"><h6 align="center">Materiales</h6></div>
                <div class="col-sm-1"><h6 align="center">Cantidad</h6></div>
                <div class="col-sm-1"><h6 align="center">Fecha de entrega</h6></div>
                <div class="col-sm-2"><h6 align="center">Responsable</h6></div>
                <div class="col-sm-2"><h6 align="center">Acciones</h6></div>
            
            </div>    
            <hr style="border:1px dotted #64b2cd; " />
            <div v-for="(ot,index) in resultsOt" :key="index">
                    <div v-if="(abierta==true && ot.abierta==1)||(abierta==false && ot.abierta==0)" class="row">
                        <div align="center" class="col-sm-1">{{ot.id}}</div>
                        <div align="center" class="col-sm-1">{{ot.ot_Peru}}</div>
                        <div class="col-sm-1">
                            <div  v-for="tupla in otsTodas[1][index]" :key="tupla.producto.id">
                                <p v-if="tupla.estado_OT==1" align="center">A</p>
                                <p v-else align="center">C</p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div  v-for="tupla in otsTodas[1][index]" :key="tupla.producto.id">
                                <p align="center">{{tupla.producto.nombre_producto}}</p>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  v-for="tupla in otsTodas[1][index]" :key="tupla.producto.id">
                                <p align="center">{{tupla.cantidad}}</p>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  v-for="tupla in otsTodas[1][index]" :key="tupla.producto.id">
                                <p align="center" type="date">{{tupla.fecha_entrega_oc}}</p>
                            </div> 
                        </div>
                        <div align="center" class="col-sm-2">{{ot.usuario.nombre_usuario}}</div>
                        <div class="col-sm-1">
                            <button type="button" data-toggle="modal" data-target="#exampleModal"  @click="masInformacion(index)" class="btn btn-info">info</button>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" data-toggle="modal" data-target="#modalEditOt" @click="editarOt(index)" class="btn btn-warning">editar</button>
                        </div>
                        <div class="col-sm-1">
                            <button v-if="ot.abierta==1" type="button" @click="cerrarOt(ot)" class="btn btn-danger">Cerrar</button>
                            <button v-if="ot.abierta==0" type="button" @click="abrirOt(ot)" class="btn btn-success">Abrir</button>
                        </div>
                        
                    </div>
                
                <hr v-if="(abierta==true && ot.abierta==1)||(abierta==false && ot.abierta==0)" style="border:1px dotted gray; " />
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
                edicionN:0,
                crearOtBool:false,
                editarOtBool:false,
                clientes:[],
                canales:[],
                tipos:[],
                usuarios:[],
                centros:[],
                categorias:[],
                seleccionados:[],
                viejos:[],
                abierta: true,
                searchOT:"",
                resultsOt: this.otsTodas[0],
                peru:null

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            volverMenu(){
                this.$emit('botonAtrasOt')
            },
            onChangueOT(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.filterResultsOt();
                    },
            filterResultsOt(){
                this.resultsOt = this.otsTodas[0].filter(item => item.id.toString().toLowerCase().indexOf(this.searchOT.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
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
                    .get('http://localhost:8000/categoriaMaterial/')
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
            editarOt(index){
                console.log("mas informacion:");
                console.log(this.otsTodas[0][index]);
                if(this.otsTodas[0][index].ot_Peru==null){
                    console.log("a");
                    this.peru= false;
                }
                else{
                    console.log("b");
                    this.peru = true;
                }
                this.otSeleccionada = this.otsTodas[0][index];
                console.log(this.otSeleccionada.fecha_recepcion);
                this. otSeleccionada.fecha_recepcion = this.otSeleccionada.fecha_recepcion.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$3-$2-$1');
                console.log(this.otSeleccionada.fecha_recepcion);
                console.log("entre")
                axios
                    .get('http://localhost:8000/seleccionados/'+this.otSeleccionada.id)
                    .then(response =>{console.log("seleccionados:");
                        console.log(response.data);
                        this.seleccionados = response.data;
                        this.viejos = response.data;})
                //usuario
                axios
                    .get('http://localhost:8000/obtenerGestores/')
                    .then(response => {this.usuarios=response.data;})
                axios
                    .get('http://localhost:8000/canalVentas/')
                    .then(response => {this.canales=response.data;})
                //ot_tipo
                axios
                    .get('http://localhost:8000/otTipo/')
                    .then(response => {this.tipos=response.data;})
                //centro costo
                axios
                    .get('http://localhost:8000/centroCosto/')
                    .then(response => {this.centros=response.data;})
                //categoria
                axios
                    .get('http://localhost:8000/categoriaMaterial/')
                    .then(response => {this.categorias=response.data;})
                //cliente
                axios
                    .get('http://localhost:8000/cliente/')
                    .then(response => {this.clientes=response.data;})
                //productos
                axios
                    .get('http://localhost:8000/producto/')
                    .then(response => {this.productos=response.data;})
                console.log("aqui activaré el bool");
                this.editarOtBool=true;    
            },
            cerrarOt(ot){
                axios
                .get('http://localhost:8000/cerrarOt/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                                //alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarOt')
                                this.abierta=true;
                                })
            },
            abrirOt(ot){
                axios
                .get('http://localhost:8000/abrirOt/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                               // alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarOt')
                                this.abierta=false;
                                })
                                this.abierta=false;
            },
            guardarCreacionOt(){
                 this.$emit('botonGuardarCreacionOt');
            },
            guardarEdicionOt(){
                this.$emit('botonGuardarEdicionOt');
            },
            guardarCreacionMaterial(){
                console.log("como que debo refrescar la wea"); 
            },
            masInformacion(index){
                console.log("mostare el modal")
                this.indexOt=index;
                 axios
                        .get('http://localhost:8000/productosYCantidadOt/'+this.otsTodas[0][index].id)
                        .then(response => {
                            console.log(response)
                            this.productos=response.data.productos;
                            this.cantidadXProducto=response.data.cantidades;
                                axios
                                .get('http://localhost:8000/obtenerTodoOt/'+this.otsTodas[0][index].id)
                                .then(response => {
                                    console.log("ds")
                                    console.log(response.data);
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