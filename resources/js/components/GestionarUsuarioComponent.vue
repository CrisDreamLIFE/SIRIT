<template>
    <div class="container">
        <button  @click="accionGestionar" type="button" class="btn btn-primary btn-lg btn-block">Gestionar Usuarios</button>        
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods:{ 
            accionGestionar(){
                this.$emit('botonGestionarUsuario')
            }
        }
    }
</script>