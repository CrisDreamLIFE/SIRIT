<template>
    <div class="container">
        <button  @click="accionGestionar" type="button" class="btn btn-secondary btn-lg btn-block">Reportabilidad</button>        
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods:{ 
            accionGestionar(){
                this.$emit('botonGestionarReporte');
            }
        }
    }
</script>