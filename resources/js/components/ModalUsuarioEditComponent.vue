<template>
<div>
    <div  class="modal " id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditUsuarioLabel">Edición de usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Nombre:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Rut:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Contraseña:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="nombreUsuario"> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="rutUsuario"> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="passUsuario"> 
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Área:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Rol:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Estado:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <multiselect v-model="areasSeleccionadas" :options="areas" deselect-label="Quitar" select-label="Agregar" :multiple="true" :clear-on-select="false" :close-on-select="false" :custom-label="nameWithLangArea" placeholder="Seleccione Áreas" label="nombre_area" track-by="nombre_area"></multiselect>
                                    </div>
                                    <div class="col-md-4">
                                        <multiselect v-model="rolesSeleccionados" :options="roles" deselect-label="Quitar" select-label="Agregar" :multiple="true" :clear-on-select="false" :close-on-select="false" :custom-label="nameWithLangRol" placeholder="Seleccione Roles" label="nombre_rol" track-by="nombre_rol"></multiselect>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="activo" class="form-control">
                                            <option  v-bind:value="1">Activo</option>
                                            <option  v-bind:value="0">Inactivo</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                                <br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="guardarCambios" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['usuarioSeleccionado','areas','roles'],
        data(){
            return {
                nombreUsuario:this.usuarioSeleccionado.nombre_usuario,
                passUsuario: this.usuarioSeleccionado.contraseña,
                rutUsuario:this.usuarioSeleccionado.rut,
                areasSeleccionadas:this.usuarioSeleccionado.areas,
                rolesSeleccionados:this.usuarioSeleccionado.roles,
                activo: this.usuarioSeleccionado.activo,
                areasViejas: this.usuarioSeleccionado.areas,
                rolesViejos: this.usuarioSeleccionado.roles
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
            nameWithLangArea ({nombre_area}) {
                return `${nombre_area}`
                },
            nameWithLangRol ({nombre_rol}) {
                return `${nombre_rol}`
                },    
            guardarCambios(){
                var params={
                    nombre: this.nombreUsuario,
                    pass:this.passUsuario,
                    rut: this.rutUsuario,
                    areas: this.areasSeleccionadas,
                    roles: this.rolesSeleccionados,
                    estado: this.activo,
                    areasViejas: this.areasViejas,
                    rolesViejos: this.rolesViejos
                }
                console.log(params);
                axios
                    .put('http://localhost:8000/usuario/'+this.usuarioSeleccionado.id, params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalEditUsuario').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarEdicionUsuario');
                        alert("Usuario Editado exitosamente");
                    })
            }
        }
    }
</script>