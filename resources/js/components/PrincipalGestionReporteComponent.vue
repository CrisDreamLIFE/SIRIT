<template>
    <div class="container">
        <br>
        <button  @click="botonSobreOt" type="button" class="btn btn-secondary btn-lg btn-block">Reportes sobre OT</button>
        <br> 
        <div v-if="otBool" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-7">
                <button  @click="botonSobreOt" type="button" class="btn btn-info btn-lg btn-block">Function one</button>  
                <br>
            </div>
            
        </div>  
        <button  @click="" type="button" class="btn btn-secondary btn-lg btn-block">Reportes sobre Sesiones de Trabajo</button>
        <br>
        <button  @click="" type="button" class="btn btn-secondary btn-lg btn-block">Listado de Trabajadores</button>
        <br>
        <button  @click="" type="button" class="btn btn-secondary btn-lg btn-block">Listado de Estaciones</button>
        <br>  
        <button  @click="" type="button" class="btn btn-secondary btn-lg btn-block">Listado de Usuarios</button>
        <br>     
    </div>
</template>

<script>
    export default {
        props: [''], 
        data(){
            return {
                otBool: false    
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            botonSobreOt(){
                this.otBool= true;
            }
        } 
    }
</script>