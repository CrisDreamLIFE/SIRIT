<template>
    <div class="container">
        <button  @click="accionTrabajar"  type="button" class="btn btn-primary btn-lg btn-block">Iniciar Trabajo</button>        
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods:{ 
            accionTrabajar(){
                this.$emit('botonIniciarTrabajo')
            }
        }
    }
</script>