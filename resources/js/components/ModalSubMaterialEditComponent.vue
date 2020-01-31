<template>
<div>
    <div  class="modal " id="modalEditSubMaterial" tabindex="-1" role="dialog" aria-labelledby="modalEditSubMaterialLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditSubMaterialLabel">Edición del Sub-Material: {{subMaterialSeleccionado.nombre}}</h5>
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
                                        <label class= "lavelFont font-weight-bold">Tipo de Material:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="nombreSubMaterial"> 
                                    </div>
                                    <div class="col-md-6">
                                        <select id="selectEstacion" v-model="tipoMaterialSubMaterial"  class="form-control">
                                            <option disabled selected >Tipos de Material</option>
                                            <option v-for="(tipo,index) in tipoSubMaterial" v-bind:key="index" v-bind:value="tipo.id">
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
                                        <textarea  class="form-control" aria-describedby="emailHelp" v-model="descripcionSubMaterial" rows="3"></textarea> 
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
        props: ['subMaterialSeleccionado','tipoMaterial'],
        data(){
            return {
                nombreSubMaterial: "",
                descripcionSubMaterial:"",
                tipoMaterialSubMaterial: ""
            }
        },
        mounted() { 
            this.nombreSubMaterial= this.subMaterialSeleccionado.nombre;
            this.descripcionSubMaterial=this.subMaterialSeleccionado.descripcion;
            this.tipoMaterialSubMaterial= this.subMaterialSeleccionado.tipo_material_id;
            console.log('Component mounted.')
        },
        methods:{
            guardarCambios(){
                var params={
                    nombre: this.nombreSubMaterial,
                    descripcion: this.descripcionSubMaterial,
                    tipoMaterial: this.tipoMaterialSubMaterial
                }
                axios
                    .put('http://localhost:8000/subProducto/'+this.subMaterialSeleccionado.id, params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalEditSubMaterial').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarEdicionSubMaterial');
                        alert("Sub-Material actualizado exitosamente");
                    })
            }
        }
    }
</script>