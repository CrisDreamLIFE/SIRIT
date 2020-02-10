<template>
    <div class="margen">
        <br>
        <div class="row container">
            <div class="col-sm">
                <button type="button" @click="crearMaterial()" data-target="#modalCreateMaterial" data-toggle="modal" class="btn btn-success">Crear Material</button>
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
                <div class="col-sm-2"><h3>Nombre</h3></div>
                <div class="col-sm-2"><h3>Código Siom</h3></div>    
                <div class="col-sm-2"><h3>Número de Plano</h3></div>
                <div class="col-sm-2"><h3>Tipo de Material</h3></div>
                <div class="col-sm-3"><h3>Descripción</h3></div>
                <div class="col-sm"></div>   
            </div>   
            <hr style="border:1px dotted red; " />  <!-- #3c70a4 -->
            <div v-for="(producto,index) in productos" :key="index">
                <div class="row">
                    <div class="col-sm-2">{{producto.nombre}}</div>
                    <div class="col-sm-2">{{producto.codigo_siom}}</div>
                    <div class="col-sm-2">{{producto.numero_plano}}</div>
                    <div class="col-sm-2"><span v-if="producto.tipo_material_id==1">Pieza</span><span v-else>Lote</span></div>
                    <div class="col-sm-3">{{producto.descripcion}}</div>
                    <div class="col-sm-1">
                        <div class="row">       
                                <button type="button" @click="editarMaterial(producto)" data-target="#modalEditMaterial" data-toggle="modal" class="btn btn-warning">E</button>
                                <button type="button" @click="eliminarMaterial(producto)" class="btn btn-danger">D</button>                
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
                desasociacionN:0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
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
            }
        } 
    }
</script>