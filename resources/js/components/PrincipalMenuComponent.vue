<template>
    <div class="container">
        <div class="row">
            {{roles}}
            <h1>Funcionalidades:</h1>
        </div>
        <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
            <iniciar-trabajo-component @botonIniciarTrabajo="iniciarTrabajo"></iniciar-trabajo-component>
        </div>
        <div v-if="roles.includes('gestor')||roles.includes('administrador')" class="row">
            <gestionar-ot-component @botonGestionarOT="iniciarGestionarOT"></gestionar-ot-component>
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
            }
        }
    }
</script>