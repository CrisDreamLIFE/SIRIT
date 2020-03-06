<template>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-6">
                <h1>Bienvenido {{usuario.nombre_usuario}}</h1>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md">
                <button type="button" v-on:click="volverLogin" class="btn btn-secondary  btn-block colorBoton">Cerrar Sesión</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-9">
                <h3>Funcionalidades:</h3>
            </div>
            <div class="col-sm-2">
                <select @change="cambioPais" required v-model="paisX" class="form-control">
                <option  value="chile">Chile</option>
                <option  value="peru">Perú</option>
            </select> 
            </div>
        </div>
        <div class="container">
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row marginTop">
                <iniciar-trabajo-component @botonIniciarTrabajo="iniciarTrabajo"></iniciar-trabajo-component>
                <br>
            </div>
            
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row marginTop">
                <gestionar-ot-component @botonGestionarOT="iniciarGestionarOT"></gestionar-ot-component>
                <br>
            </div>
            
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row marginTop">
                <gestionar-material-component @botonGestionarMaterial="iniciarGestionarMateriales"></gestionar-material-component>
                <br>
            </div>
            
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row marginTop">
                <gestionar-sub-material-component @botonGestionarSubMaterial="iniciarGestionarSubMateriales"></gestionar-sub-material-component>
                <br>
            </div>
            
            <div v-if="roles.includes('administrador')" class="row marginTop">
                <gestionar-usuario-component @botonGestionarUsuario="iniciarGestionarUsuarios"></gestionar-usuario-component>
                <br>
                <p></p>
            </div>
            
            <div v-if="roles.includes('gestor')||roles.includes('administrador')
            ||roles.includes('visualizador')" class="row marginTop">
                <gestionar-reporte-component @botonGestionarReporte="iniciarGestionarReporte"></gestionar-reporte-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['usuario','roles','pais'],
        data(){
            return {
                paisX: this.pais,
                rolX: true,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{ 
            volverLogin(){
            this.$emit('logout');    
            },
            cambioPais(){
                console.log("entre al evento");
                var params = {
                        pais: this.paisX,
                };
                axios
                    .post('http://localhost:8000/cambiarPais', params)
                    .then(response => {
                        console.log("respuesta");
                        console.log(response.data);})
                this.$emit('cambioPais');
            },
            iniciarTrabajo(){
                this.$emit('botonIniciarTrabajo')
            },
            iniciarGestionarOT(){
                this.$emit('botonGestionarOT')
            },
            iniciarGestionarReporte(){
                this.$emit('botonGestionarReporte')
            },
            iniciarGestionarMateriales(){
                this.$emit('botonGestionarMaterial')
            },
            iniciarGestionarSubMateriales(){
                console.log("iniciarGestionarSubMateriales");
                this.$emit('botonGestionarSubMaterial')
            },
            iniciarGestionarUsuarios(){
                console.log("iniciarGestionarUsuarios");
                this.$emit('botonGestionarUsuario')
            }

        }
    }
</script>

<style scoped>
    .marginTop{
        margin-top: 25px;
    }
</style>