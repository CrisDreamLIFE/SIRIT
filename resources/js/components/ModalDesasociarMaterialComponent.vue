<template>
<div>
    <div  class="modal" data-backdrop="static" id="modalDesasociarMaterial" tabindex="-1" role="dialog" aria-labelledby="modalDesasociarMaterialLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDesasociarMaterialLabel">Desasociación de Materiales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class= "lavelFont font-weight-bold">Material:</label>
                                    </div>
                                    <div class="col-md-5">
                                        <label class= "lavelFont font-weight-bold">Sub-Material:</label>
                                    </div>
                                    <div class="col-md-2">
                                         
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <br>
                                        <select id="ds" @change="onChangeProducto(productos[productoSeleccionado].id)" v-model="productoSeleccionado" class="form-control">
                                            <option disabled selected >Material</option>
                                            <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                               {{ producto.nombre }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-7">
                                        <div class="container color2">
                                            <div v-for="(subProducto,indexA) in asociaciones" v-bind:key="indexA" v-bind:value="indexA">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div v-if="subProductos.length!=0">{{ subProductos[indexA].nombre}}</div>
                                                    </div>
                                                    <div class="col-md-2">
                                                            <button type="button" v-on:click="quitarAsociacion(indexA)" class="btn btn-danger">-</button>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="guardarCambios"  data-dismiss="modal"  class="btn btn-primary">Finalizar</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['productos',''],
        data(){
            return {
                nombreSubMaterial: "",
                descripcionSubMaterial:"",
                tipoMaterialSubMaterial: "",
                subProductoSeleccionado:"",
                productoSeleccionado:"",
                asociaciones:[],
                asociacionesEnteras:[],
                subProductos:[]
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
            onChangeProducto(index){
                this.subProductos=[]
                axios
                .get('http://localhost:8000/subProductosOP/'+index)
                .then(response => {
                    console.log(response.data)
                    this.asociaciones=response.data;
                    })
                axios
                .get('http://localhost:8000/subProductos/'+index)
                .then(response => {
                    console.log(response.data)
                    this.subProductos=response.data;
                    })
            },
            quitarAsociacion(index){
                console.log("index: "+index);
                axios
                    .delete('http://localhost:8000/productoSubProductoww/'+this.asociaciones[index].id)
                    .then(response => {
                        console.log(response.data);
                        alert("Asociación eliminada exitosamente");
                        this.onChangeProducto(this.asociaciones[index].producto_id);
                    })     
            },
            guardarCambios(){
                this.$emit('botonGuardarDesasociacionMaterial');
                        //$('#modalAsociarMaterial').modal('hide');
                        //$('.modal-backdrop').hide();
                        //alert("Asociación creada exitosamente");
        
            }
        }
    }
</script>
<style scoped>
    .color{
        margin-top:  20px;
        background-color:#3c70a4;
        border-color: #64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
    }
    .color2{
        margin-top:  20px;
        background-color:#ffffff;
        border-color: 64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
        color: #3c70a4;
    }
    .lavelFont{
        font-size: 20px;
        color: #da9833;
    }
    .lavelFont2{
        font-size: 20px;
        color: white;
    }
    .colorNav{
        background-color: 64b2cd;
    }
    .h2{
        color: #3c70a4;
    }
    .aa{
        color: #000;
    }
    .h3{
        color: #da9833;
    }
    .colorBoton{
        color: white;
    }
    .style3{
        border-top: 1px dashed #8c8b8b;
    }
    .error{
         color: red;
    }
    input:invalid {
        border: 1px solid red;
    }
    input:valid {
        border: 1px solid green;
    }
</style>