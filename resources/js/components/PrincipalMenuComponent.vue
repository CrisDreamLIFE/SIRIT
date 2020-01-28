<template>
    <div class="container">
        <div class="row">
            {{roles}}
            <h1>Funcionalidades:</h1>
        </div>
        <div v-if="roles.includes('iniciarTrabajo')" class="row">
            <iniciar-trabajo-component @botonIniciarTrabajo="iniciarTrabajo"></iniciar-trabajo-component>
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
            }
        }
    }
</script>