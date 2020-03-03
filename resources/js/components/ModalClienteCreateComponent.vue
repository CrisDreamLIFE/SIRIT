<template>
<div>
    <div  class="modal " id="modalCreateCliente" tabindex="-1" role="dialog" aria-labelledby="modalCreateClienteLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateClienteLabel">Creacion de nuevo Cliente</h5>
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
                                        <label class= "lavelFont font-weight-bold">Correo:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="nombre"> 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email"  class="form-control" aria-describedby="emailHelp" v-model="correo">   
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Teléfono:</label> 
                                    </div>
                                    <div class="col-md-6">
                                        <label class= "lavelFont font-weight-bold">Nombre de Contacto:</label> 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="telefono"> 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="nombreContacto"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class= "lavelFont font-weight-bold">Observación:</label> 
                                    </div>
                                    <div class="col-md-12">
                                        <textarea  class="form-control" aria-describedby="emailHelp" v-model="observacion" rows="3"></textarea> 
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
        props: [],
        data(){
            return {
                nombre: "",
                correo:"",
                telefono:"",
                nombreContacto:"",
                observacion: ""
            }
        },
        mounted() { 
            console.log('Component mounted.')
            console.log("dsfdsf");
        },
        methods:{
            guardarCambios(){
                var params={
                    nombre: this.nombre,
                    correo: this.correo,
                    telefono: this.telefono,
                    nombreContacto: this.nombreContacto,
                    observacion: this.observacion
                }
                console.log(params);
                axios
                    .post('http://localhost:8000/cliente/', params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalCreateCliente').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarCreacionCliente');
                        alert("Cliente creado exitosamente");
                    })
            }
        }
    }
</script>