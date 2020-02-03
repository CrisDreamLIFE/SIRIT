<template>
    <div class="container">
        <br>
        <div class="row">
            
            <div class="col-sm">
                <button type="button" @click="crearSubMaterial()" data-target="#modalCreateSubMaterial" data-toggle="modal" class="btn btn-success">Crear Sub-Material</button>
                <br><br>
                <div v-if="crearSubMaterialBool"> <!-- CREATE -->
                    <modal-sub-material-create-component
                    :key="creacionN"
                    :tipoMaterial="tipoMaterial"
                    @botonGuardarCreacionSubMaterial="guardarCreacionSubMaterial">
                    </modal-sub-material-create-component>
                </div>
            </div> 
            <div class="col-sm">
                <button type="button" @click="asociarMaterial()" data-target="#modalAsociarMaterial" data-toggle="modal" class="btn btn-secondary">Asociar Materiales</button>
                <div v-if="asociarMaterialBool"> <!-- asociarMateriales -->
                    <modal-asociar-material-component
                    :key="asociacionN"
                    :productos="productos"
                    :subProductos="subProductos"
                    @botonGuardarAsociacionMaterial="guardarAsociacionMaterial">
                    </modal-asociar-material-component>
                </div>
            </div>
            <div class="col-sm">
                <button type="button" @click="desasociarMaterial()" data-target="#modalDesasociarMaterial" data-toggle="modal" class="btn btn-secondary">Desasociar Materiales</button>
                <div v-if="desasociarMaterialBool"> <!-- desasociarMateriales -->
                    <modal-desasociar-material-component
                    :key="desasociacionN"
                    :productos="productos"
                    @botonGuardarDesasociacionMaterial="guardarDesasociacionMaterial">
                    </modal-desasociar-material-component>
                </div>
            </div>
        
        </div>
        <div v-if="editarSubMaterialBool"> <!-- EDIT -->
            <modal-sub-material-edit-component
            :key="edicionN"
            :subMaterialSeleccionado="subMaterialSeleccionado"
            :tipoMaterial="tipoMaterial"
            @botonGuardarEdicionSubMaterial="guardarEdicionSubMaterial">
            </modal-sub-material-edit-component> 
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-3"><h3>Nombre</h3></div>
                <div class="col-sm-3"><h3>Tipo de Material</h3></div>
                <div class="col-sm-4"><h3>Descripción</h3></div>
                <div class="col-sm"></div>   
            </div>   
            <hr style="border:1px dotted red; " />  <!-- #3c70a4 -->
            <div v-for="(subProducto,index) in subProductos" :key="index">
                <div class="row">
                    <div class="col-sm-3">{{subProducto.nombre}}</div>
                    <div class="col-sm-3"><span v-if="subProducto.tipo_material_id==1">Pieza</span><span v-else>Lote</span></div>
                    <div class="col-sm-4">{{subProducto.descripcion}}</div>
                    <div class="col-sm-1">
                        <div class="row">       
                                <button type="button" @click="editarSubMaterial(subProducto)" data-target="#modalEditSubMaterial" data-toggle="modal" class="btn btn-warning">E</button>
                                <button type="button" @click="eliminarSubMaterial(subProducto)" class="btn btn-danger">D</button>                
                        </div>
                    </div>
                </div>
                <hr style="border:1px dotted gray; " />
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
                desasociacionN:0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
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
            }
        } 
    }
</script>