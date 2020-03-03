<template>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-9">
                <h1>Funcionalidades:</h1>
            </div>
            <div class="col-sm-2">
                <select @change="cambioPais" required v-model="paisX" class="form-control">
                <option  value="chile">Chile</option>
                <option  value="peru">Perú</option>
            </select> 
            </div>
        </div>
        <div class="container">
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
                <iniciar-trabajo-component @botonIniciarTrabajo="iniciarTrabajo"></iniciar-trabajo-component>
            </div>
            <br>
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
                <gestionar-ot-component @botonGestionarOT="iniciarGestionarOT"></gestionar-ot-component>
            </div>
            <br>
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
                <gestionar-material-component @botonGestionarMaterial="iniciarGestionarMateriales"></gestionar-material-component>
            </div>
            <br>
            <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
                <gestionar-sub-material-component @botonGestionarSubMaterial="iniciarGestionarSubMateriales"></gestionar-sub-material-component>
            </div>
            <br>
            <div v-if="roles.includes('administrador')" class="row">
                <gestionar-usuario-component @botonGestionarUsuario="iniciarGestionarUsuarios"></gestionar-usuario-component>
            </div>
            <br>
            <div v-if="roles.includes('gestor')||roles.includes('administrador')
            ||roles.includes('visualizador')" class="row">
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