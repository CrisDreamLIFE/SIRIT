<template>
<div>
    <div  class="modal" id="modalAsociarMaterial" tabindex="-1" role="dialog" aria-labelledby="modalAsociarMaterialLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAsociarMaterialLabel">Asociación de Materiales</h5>
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
                                        <select id="ds" @change="onChangeAsociados()" v-model="productoSeleccionado" class="form-control">
                                            <option disabled selected >Material</option>
                                            <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                                {{ producto.nombre_producto }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-5">
                                        <select id="dds" v-model="subProductoSeleccionado"  class="form-control">
                                            <option disabled selected >Sub-Material</option>
                                            <option v-for="(subProducto,indexA) in subProductos" v-bind:key="indexA" v-bind:value="indexA">
                                                {{ subProducto.nombre_sub_producto }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" v-on:click="agregarAsociacion" class="btn btn-success">+</button>    
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container row">
                                <label class= "lavelFont font-weight-bold">Asociaciones:</label>   
                            </div>
                            <div class="container color5">
                                <div v-for="(linea,indexZ) in asociacionesEnteras" v-bind:key="indexZ">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>* {{linea[0].nombre_producto}}</p>
                                        </div>
                                        <div class="col-md-5">
                                            <p>{{linea[1].nombre_sub_producto}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"  v-on:click="quitarAsociacion(indexZ)" class="btn btn-danger">-</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="guardarCambios" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['productos','subProductos'],
        data(){
            return {
                nombreSubMaterial: "",
                descripcionSubMaterial:"",
                tipoMaterialSubMaterial: "",
                subProductoSeleccionado:"",
                productoSeleccionado:"",
                asociaciones:[],
                asociacionesEnteras:[]
                //subProductos:[]
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
            onChangeAsociados(){
               /* console.log("dsfssa");
                var aux3=[]
                axios
                    .get('http://192.168.1.50/SIRIT/public/subProductos/'+this.productos[this.productoSeleccionado].id)
                    .then(response => {  
                        aux3 = response.data;
                        for(var i=0;i<aux3.length;i++){
                            var aux= [];
                            aux.push(this.productos[this.productoSeleccionado].id)  //idprod , idsub
                            aux.push(aux3[i].id);
                            this.asociaciones.push(aux) 
                            var aux2 = [];
                            aux2.push(this.productos[this.productoSeleccionado])  //idprod , idsub
                            aux2.push(aux3[i]);
                            this.asociacionesEnteras.push(aux2);

                        }  
                    })*/
            },
            quitarAsociacion(index){
                this.asociacionesEnteras.splice( index, 1 );
                this.asociaciones.splice( index, 1 );
            },
            agregarAsociacion(){
                var aux2 = [];
                aux2.push(this.productos[this.productoSeleccionado]);
                aux2.push(this.subProductos[this.subProductoSeleccionado]);
                this.asociacionesEnteras.push(aux2);
                var aux= [];
                aux.push(this.productos[this.productoSeleccionado].id)
                aux.push(this.subProductos[this.subProductoSeleccionado].id);
                this.asociaciones.push(aux)
            },
            guardarCambios(){
                var params={
                    asociaciones: this.asociaciones,
                }
                console.log("agregando asociacion");
                console.log(params);
                axios
                    .post('http://localhost:8000/productoSubProducto/', params)
                    .then(response => {
                        this.$emit('botonGuardarAsociacionMaterial');
                        console.log(response.data);
                        $('#modalAsociarMaterial').modal('hide');
                        $('.modal-backdrop').hide();            
                        alert("Asociación creada exitosamente");
                    })
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