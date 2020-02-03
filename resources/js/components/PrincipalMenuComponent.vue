<template>
    <div class="container">
        <div class="row">
            <h1>Funcionalidades:</h1>
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
        </div>
    </div>
</template>

<script>
    export default {
        props: ['usuario','roles'],
        data(){
            return {
                rolX: true,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{ 
            iniciarTrabajo(){
                this.$emit('botonIniciarTrabajo')
            },
            iniciarGestionarOT(){
                this.$emit('botonGestionarOT')
            },
            iniciarGestionarMateriales(){
                this.$emit('botonGestionarMaterial')
            },
            iniciarGestionarSubMateriales(){
                console.log("iniciarGestionarSubMateriales");
                this.$emit('botonGestionarSubMaterial')
            }

        }
    }
</script>