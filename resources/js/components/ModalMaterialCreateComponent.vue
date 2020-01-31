<template>
<div>
    <div  class="modal " id="modalCreateMaterial" tabindex="-1" role="dialog" aria-labelledby="modalCreateMaterialLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateMaterialLabel">Creacion de nuevo Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Nombre:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Código Siom:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="nombreMaterial">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="codigoSiomMaterial">
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Número de Plano:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Tipo de Material:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="numeroPlanoMaterial"> 
                                    </div>
                                    <div class="col-md-6">
                                        <select id="selectEstacion" v-model="tipoMaterialMaterial"  class="form-control">
                                            <option disabled selected >Tipos de Material</option>
                                            <option v-for="(tipo,index) in tipoMaterial" v-bind:key="index" v-bind:value="tipo.id">
                                                {{ tipo.nombre }}
                                            </option>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class= "lavelFont font-weight-bold">Descripción:</label> 
                                    </div>
                                    <div class="col-md-12">
                                        <textarea  class="form-control" aria-describedby="emailHelp" v-model="descripcionMaterial" rows="3"></textarea> 
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
        props: ['tipoMaterial',''],
        data(){
            return {
                nombreMaterial: "",
                codigoSiomMaterial: "",
                numeroPlanoMaterial:"",
                descripcionMaterial:"",
                tipoMaterialMaterial: ""
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
            guardarCambios(){
                var params={
                    nombre: this.nombreMaterial,
                    codigoSiom: this.codigoSiomMaterial,
                    numeroPlano: this.numeroPlanoMaterial,
                    descripcion: this.descripcionMaterial,
                    tipoMaterial: this.tipoMaterialMaterial
                }
                axios
                    .post('http://localhost:8000/producto/', params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalCreateMaterial').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarCreacionMaterial');
                        alert("Material creado exitosamente");
                    })
            }
        }
    }
</script>