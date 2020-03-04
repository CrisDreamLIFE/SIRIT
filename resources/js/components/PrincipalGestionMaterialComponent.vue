<template>
    <div class="margen">
        <br>
        <div class="row container">
            <div class="col-sm-2"><!--colorBoton-->
                <button type="button" v-on:click="volverMenu" class="btn btn-secondary  btn-block colorBoton">Atrás</button>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-3">
                <button type="button" @click="asociarMaterial()" data-target="#modalAsociarMaterial" data-toggle="modal" class="btn btn-primary">Asociar Materiales</button>
                <div v-if="asociarMaterialBool"> <!-- asociarMateriales -->
                    <modal-asociar-material-component
                    :key="asociacionN"
                    :productos="productos"
                    :subProductos="subProductos"
                    @botonGuardarAsociacionMaterial="guardarAsociacionMaterial">
                    </modal-asociar-material-component>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <button type="button" @click="desasociarMaterial()" data-target="#modalDesasociarMaterial" data-toggle="modal" class="btn btn-primary">Desasociar Materiales</button>
                <div v-if="desasociarMaterialBool"> <!-- desasociarMateriales -->
                    <modal-desasociar-material-component
                    :key="desasociacionN"
                    :productos="productos"
                    @botonGuardarDesasociacionMaterial="guardarDesasociacionMaterial">
                    </modal-desasociar-material-component>
                </div>
            </div>
        </div>
        <br>
        <div class="row container">
            <div class="col-sm-2">
                <button type="button" @click="crearMaterial()" data-target="#modalCreateMaterial" data-toggle="modal" class="btn btn-success btn-lg btn-block">Crear Material   </button>
                <br><br>
                <div v-if="crearMaterialBool"> <!-- CREATE -->
                    <modal-material-create-component
                    :key="creacionN"
                    :tipoMaterial="tipoMaterial"
                    :clientes="clientes"
                    @botonGuardarCreacionMaterial="guardarCreacionMaterial">
                    </modal-material-create-component> 
                </div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
                <div class="row"> <!-- este es el buscador, lo vemos mas tarde o altiro mejor-->
                    <div class="col-sm">
                        <input id="7" class="form-control form-control-lg form-control-borderless" placeholder="Nombre Material" type="search" v-model="searchMaterial" @input="onChangueMaterial"/>
                    </div>
                    <!--end of col-->
                </div>
            </div>
            <div class="col-sm-2">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <input class="form-check-input" :value="true" :unchecked-value="true" v-model="abierta" id="abierta" type="checkbox">
                        <label style="font-size:18px" for = "abierta">{{'   Abiertas'}}</label> 
                    </div>
                 </div>    
            </div> 
            
        </div>
        <div v-if="editarMaterialBool"> <!-- EDIT -->
            <modal-material-edit-component
            :key="edicionN"
            :materialSeleccionado="materialSeleccionado"
            :tipoMaterial="tipoMaterial"
            @botonGuardarEdicionMaterial="guardarEdicionMaterial">
            </modal-material-edit-component> 
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-2"><h6 align="center">Nombre</h6></div>
                <div class="col-sm-1"><h6 align="center">Código Siom</h6></div>    
                <div class="col-sm-1"><h6 align="center">Número de Plano</h6></div>
                <div class="col-sm-1"><h6 align="center">Tipo de Material</h6></div>
                <div class="col-sm-4"><h6 align="center">Descripción</h6></div>
                <div class="col-sm-2"><h6 align="center">Acciones</h6></div>  
            </div>   
            <hr style="border:1px dotted red; " />  <!-- #3c70a4 -->
            <div v-for="(producto,index) in resultsProductos" :key="index">
                <div v-if="(abierta==true && producto.activo==1)||(abierta==false && producto.activo==0)" class="row">
                    <div class="col-sm-2" align="center">{{producto.nombre_producto}}</div>
                    <div class="col-sm-1" align="center">{{producto.codigo_siom}}</div>
                    <div class="col-sm-1" align="center">{{producto.numero_plano}}</div>
                    <div class="col-sm-1" align="center"><span v-if="producto.tipo_material_id==1">Pieza</span><span v-else>Lote</span></div>
                    <div class="col-sm-4" align="center">{{producto.descripcion}}</div>
                    <div class="col-sm-2">
                        <div class="row"> 
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <button type="button" @click="editarMaterial(producto)" data-target="#modalEditMaterial" data-toggle="modal" class="btn btn-warning">Editar</button>
                            </div>      
                            <div class="col-sm-4">  
                                <button v-if="producto.activo==1" type="button" @click="cerrarProducto(producto)" class="btn btn-danger">Desactivar</button>
                                <button v-if="producto.activo==0" type="button" @click="abrirProducto(producto)" class="btn btn-success">Activar</button>                
                            </div>  
                        </div>
                    </div>
                </div>
                <hr v-if="(abierta==true && producto.activo==1)||(abierta==false && producto.activo==0)" style="border:1px dotted gray; " />
            </div>
        </div>   
    </div>
</template>

<script>
    export default {
        props: ['productos'], 
        data(){
            return {
                editarMaterialBool:false,
                crearMaterialBool:false,
                materialSeleccionado:null,
                asociarMaterialBool:false,
                desasociarMaterialBool:false,
                tipoMaterial:[],
                clientes:[],
                subProductos:[],
                edicionN:0,
                creacionN:0,
                asociacionN:0,
                desasociacionN:0,
                searchMaterial:"",
                resultsProductos: this.productos,
                abierta: true
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            volverMenu(){
                this.$emit('botonAtrasMaterial')
            },
            onChangueMaterial(){
                        console.log("productos:");
                        console.log(this.productos);
                        this.filterResultsMaterial();
                    },
            filterResultsMaterial(){
                this.resultsProductos = this.productos.filter(item => item.nombre_producto.toLowerCase().indexOf(this.searchMaterial.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
            eliminarMaterial(producto){
                axios
                .delete('http://localhost:8000/producto/'+ producto.id) //solicitar tipo material
                            .then(response => {
                                console.log(response);
                                alert("Material eliminado exitosamente");
                                this.$emit('botonEliminarCreacionMaterial')
                                })
            },
            editarMaterial(producto){ 
                this.materialSeleccionado = producto;
                axios
                    .get('http://localhost:8000/tipoMaterial') //solicitar tipo material
                                .then(response => {
                                    this.tipoMaterial = response.data;
                                    
                                    })
                this.editarMaterialBool = true;  
            },
            crearMaterial(){ 
                axios
                .get('http://localhost:8000/tipoMaterial') //solicitar tipo material
                            .then(response => {
                                this.tipoMaterial = response.data;
                                })
                axios
                .get('http://localhost:8000/cliente') //solicitar clientes
                            .then(response => {
                                this.clientes = response.data;
                                })
                this.crearMaterialBool = true; 
            },
            asociarMaterial(){
                axios
                .get('http://localhost:8000/subProducto') //solicitar tipo material
                            .then(response => {
                                this.subProductos = response.data;
                                console.log(this.subProductos);
                                })
                this.asociarMaterialBool = true;
            },
            desasociarMaterial(){
              /*  axios
                .get('http://localhost:8000/producto') //solicitar tipo material
                .then(response => {
                    this.productos = response.data;
                    console.log(this.productos);
                    })*/
                this.desasociarMaterialBool = true;
            },
            guardarCreacionMaterial(){
                this.creacionN +=1;
                this.$emit('botonGuardarCreacionMaterial')
            },
            guardarEdicionMaterial(){
                this.edicionN +=1;
                this.$emit('botonGuardarEdicionMaterial')
                
            },
            guardarAsociacionMaterial(){
                this.asociacionN +=1;
                this.$emit('botonGuardarAsociacionMaterial')//no se hace
            },
            guardarDesasociacionMaterial(){
                console.log("reeplazo la wea")
                this.desasociacionN +=1;
                //no se hace
            },
            cerrarProducto(ot){
                axios
                .get('http://localhost:8000/cerrarProducto/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                                //alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarProducto')
                                this.abierta=true;
                                })
            },
            abrirProducto(ot){
                axios
                .get('http://localhost:8000/abrirProducto/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                               // alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarProducto')
                                this.abierta=false;
                                })
                                this.abierta=false;
            },
        } 
    }
</script>