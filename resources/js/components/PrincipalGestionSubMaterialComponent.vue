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
                <button type="button" @click="crearSubMaterial()" data-target="#modalCreateSubMaterial" data-toggle="modal" class="btn btn-block btn-success">Crear Sub-Material</button>
                <br><br>
                <div v-if="crearSubMaterialBool"> <!-- CREATE -->
                    <modal-sub-material-create-component
                    :key="creacionN"
                    :tipoMaterial="tipoMaterial"
                    @botonGuardarCreacionSubMaterial="guardarCreacionSubMaterial">
                    </modal-sub-material-create-component>
                </div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
                <div class="row"> <!-- este es el buscador, lo vemos mas tarde o altiro mejor-->
                    <div class="col-sm">
                        <input id="7" class="form-control form-control-lg form-control-borderless" placeholder="Nombre Sub-Material" type="search" v-model="searchSubMaterial" @input="onChangueSubMaterial"/>
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
        <div v-if="editarSubMaterialBool"> <!-- EDIT -->
            <modal-sub-material-edit-component
            :key="edicionN"
            :subMaterialSeleccionado="subMaterialSeleccionado"
            :tipoMaterial="tipoMaterial"
            @botonGuardarEdicionSubMaterial="guardarEdicionSubMaterial"
            @botonCerrarEdicionSubMaterial="cerrarEdicionSubMaterial">
            </modal-sub-material-edit-component> 
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-3"><h6 align="center">Nombre</h6></div>
                <div class="col-sm-3"><h6 align="center">Tipo de Material</h6></div>
                <div class="col-sm-4"><h6 align="center">Descripción</h6></div>
                <div class="col-sm"><h6 align="center">Acciones</h6></div>   
            </div>   
            <hr style="border:1px dotted red; " />  <!-- #3c70a4 -->
            <div v-for="(subProducto,index) in resultsSubProductos" :key="index">
                <div v-if="(abierta==true && subProducto.activo==1)||(abierta==false && subProducto.activo==0)" class="row">
                    <div class="col-sm-3" align="center">{{subProducto.nombre_sub_producto}}</div>
                    <div class="col-sm-3" align="center"><span v-if="subProducto.tipo_material_id==1">Pieza</span><span v-else>Lote</span></div>
                    <div class="col-sm-4" align="center">{{subProducto.descripcion}}</div>
                    <div class="col-sm">
                        <div class="row"> 
                            <div class="col-sm-4">         
                                <button type="button" @click="editarSubMaterial(subProducto)" data-target="#modalEditSubMaterial" data-toggle="modal" class="btn btn-warning">Editar</button>
                            </div>
                            <div class="col-sm-4"> 
                                <button v-if="subProducto.activo==1" type="button" @click="cerrarSubProducto(subProducto)" class="btn btn-danger">Desactivar</button>
                                <button v-if="subProducto.activo==0" type="button" @click="abrirSubProducto(subProducto)" class="btn btn-success">Activar</button>                
                            </div>
                        </div>
                    </div>
                </div>
                <hr v-if="(abierta==true && subProducto.activo==1)||(abierta==false && subProducto.activo==0)" style="border:1px dotted gray; " />
            </div>
        </div>   
    </div>
</template>

<script>
    export default {
        props: ['subProductos'], 
        data(){
            return {
                editarSubMaterialBool:false,
                crearSubMaterialBool:false,
                asociarMaterialBool:false,
                desasociarMaterialBool:false,
                subMaterialSeleccionado:null,
                productos: null,
                tipoMaterial:[],
                edicionN:0,
                creacionN:0,
                asociacionN:0,
                desasociacionN:0,
                searchSubMaterial:"",
                resultsSubProductos: this.subProductos,
                abierta: true
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            volverMenu(){
                this.$emit('botonAtrasSubMaterial')
            },
            onChangueSubMaterial(){
                        console.log("productos:");
                        console.log(this.productos);
                        this.filterResultsSubMaterial();
                    },
            filterResultsSubMaterial(){
                this.resultsSubProductos = this.subProductos.filter(item => item.nombre_sub_producto.toLowerCase().indexOf(this.searchSubMaterial.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
            eliminarSubMaterial(subProducto){
                axios
                .delete('http://localhost:8000/subProducto/'+ subProducto.id) //solicitar tipo material
                            .then(response => {
                                console.log(response);
                                alert("Sub-Material eliminado exitosamente");
                                this.$emit('botonEliminarCreacionSubMaterial')
                                })
            },
            editarSubMaterial(subProducto){ 
                this.subMaterialSeleccionado = subProducto;
                axios
                    .get('http://localhost:8000/tipoMaterial') //solicitar tipo material
                                .then(response => {
                                    this.tipoMaterial = response.data;
                                    
                                    })
                this.editarSubMaterialBool = true;  
            },
            asociarMaterial(){
                axios
                .get('http://localhost:8000/producto') //solicitar tipo material
                            .then(response => {
                                this.productos = response.data;
                                console.log(this.productos);
                                })
                this.asociarMaterialBool = true;
            },
            desasociarMaterial(){
                axios
                .get('http://localhost:8000/producto') //solicitar tipo material
                .then(response => {
                    this.productos = response.data;
                    console.log(this.productos);
                    })
                this.desasociarMaterialBool = true;
            },
            crearSubMaterial(){
                axios
                .get('http://localhost:8000/tipoMaterial') //solicitar tipo material
                            .then(response => {
                                this.tipoMaterial = response.data;
                                })
                this.crearSubMaterialBool = true; 
            },
            guardarCreacionSubMaterial(){
                this.creacionN +=1;
                this.$emit('botonGuardarCreacionSubMaterial')
            },
            cerrarEdicionSubMaterial(){
                this.edicionN +=1;
                axios
                this.$emit('botonGuardarEdicionSubMaterial');
            },
            guardarEdicionSubMaterial(){
                this.edicionN +=1;
                this.$emit('botonGuardarEdicionSubMaterial')
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
            cerrarSubProducto(ot){
                axios
                .get('http://localhost:8000/cerrarSubProducto/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                                //alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarSubProducto')
                                this.abierta=true;
                                })
            },
            abrirSubProducto(ot){
                axios
                .get('http://localhost:8000/abrirSubProducto/'+ ot.id) 
                            .then(response => {
                                console.log(response);
                               // alert("OT eliminada exitosamente");
                                this.$emit('botonEliminarSubProducto')
                                this.abierta=false;
                                })
                                this.abierta=false;
            },
        } 
    }
</script>