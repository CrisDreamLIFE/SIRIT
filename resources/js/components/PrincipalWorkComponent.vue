<template>

        <!-- Just an image -->
    
    <div class= "container todo">
        <br>
        <h2 class="h2">Especificaciones del Trabajo:</h2>
        <div class="container color">
            <form>
                <div class="form-group">
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Estación:</label>
                        </div>
                        <div class="col-sm-6">
                            <label  class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Trabajadores:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <select  v-model="estacionSeleccionada" @change="onChangeEstación()" class="form-control">
                            <option disabled selected >Estaciones</option>
                            <option v-for="estacion in estaciones" v-bind:key="estacion.id" v-bind:value="estacion.id">
                                {{ estacion.codigo }}
                            </option>
                            </select>  
                        </div>
                        <div class="col-sm-5">
                            <select  :disabled="!estacionSeleccionadaBool" v-model="trabajadorSeleccionado" class="form-control" >
                            <option disabled selected >Trabajadores</option>
                            <option v-for="trabajador in trabajadores" v-bind:key="trabajador.id" v-bind:value="trabajador.id">
                                {{ trabajador.nombre }}
                            </option>
                            </select>     
                        </div>
                        <div class="col-sm-1">
                            <button type="button"  v-on:click= "agregarTrabajador()" class="btn btn-success">+</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione OT:</label>
                        </div>
                        <div class="col-sm-6">
                                <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Producto:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <select  v-model="otSeleccionada" @change="onChangeOt()" class="form-control" >
                            <option disabled selected >orden de trabajo</option>
                            <option v-for="ot in ots" v-bind:key="ot.id" v-bind:value="ot.id">
                                {{ ot.id }}
                            </option>
                            </select>     
                        </div>
                        <div class="col-sm-1">
                            <button type="button"  v-on:click= "agregarOt()" class="btn btn-success">+</button>
                        </div>
                            <div class="col-sm-5">
                                <select  :disabled="!otSeleccionadaBool" v-model="productoSeleccionado" class="form-control" >
                                <option disabled selected >Productos</option>
                                <option v-for="producto in productos" v-bind:key="producto.id" v-bind:value="producto.id">
                                {{ producto.nombre }}
                                </option>
                                </select> 
                            </div>
                            <div class="col-sm-1">
                                <button type="button"  v-on:click= "agregarProducto()" class="btn btn-success">+</button>
                            </div>
                        </div>
                    <br>                   
                </div>
            </form>
        </div>
        <br><br>
        <div class="row">
            <div class="col-sm-6">
                <h3 class="h3">Lista de trabajadores seleccionados:</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">  
                <div class="container color2">
                    <br>
                    <div v-for="(trabajador,index) in trabajadoresSeleccionados" v-bind:key="index">
                        <p>- {{trabajador.nombre}}</p>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-sm-6">
                <h3 class="h3">Lista de OTs seleccionadas:</h3>
            </div>
            <div class="col-sm-6">
                <h3 class="h3">Lista de Productos seleccionados:</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="container color2">
                    <br>
                    <div v-for="(ot,index) in otsSeleccionadas" v-bind:key="index">
                        <p>- {{ot.id}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="container color2">
                    <br>
                    <div v-for="(producto,index) in productosSeleccionados" v-bind:key="index">
                        <p>- {{producto.nombre}}</p>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row justify-content-center colorBoton">
            <button type="button" class="btn btn-primary  colorBoton">Primary</button>
        </div>
        
        <br><br><br><br>  
    </div>      
    
</template>

<script>
    export default {
        data(){
            return {
                estaciones: [],
                estacionSeleccionada: null,
                estacionSeleccionadaBool: false,
                trabajadores:[],
                trabajadorSeleccionado: null,
                trabajadoresSeleccionados: [],
                ots: [],
                otSeleccionada: null,
                otSeleccionadaBool: false,
                otsSeleccionadas: [],
                productos: [],
                productoSeleccionado: null,
                productosSeleccionados: []
            };
        },
        mounted() {
            axios
            .get('http://localhost:8000/estacion')
            .then(response => (this.estaciones = response.data))
            console.log('Component mounted.')  

            axios
            .get('http://localhost:8000/otAbierta')
            .then(response => (this.ots = response.data))
            console.log('Component mounted.')
        },
        methods:{
            agregarTrabajador(){
                this.trabajadoresSeleccionados.push(this.trabajadores[this.trabajadorSeleccionado-1])
            },
            agregarOt(){
                this.otsSeleccionadas.push(this.ots[this.otSeleccionada-1])
            },
            agregarProducto(){
                this.productosSeleccionados.push(this.productos[this.productoSeleccionado-1])
            },
            onChangeEstación(){
                var i;
                var index = -1;
                if(this.estacionSeleccionada != null){
                    console.log("el valor de index: ")
                    console.log(index)
                    axios
                    .get('http://localhost:8000//trabajadores/'+this.estacionSeleccionada)
                    .then(response => {
                        this.trabajadores = response.data
                        console.log(this.trabajadores);
                        this.estacionSeleccionadaBool = true;})          
                }
            },
             onChangeOt(){
                if(this.otSeleccionada != null){
                    console.log("ot seleccionada: ")
                    console.log(this.otSeleccionada)
                    axios
                    .get('http://localhost:8000/productosOt/'+this.otSeleccionada)
                    .then(response => {
                        this.productos = response.data
                        console.log("nombre del producto primero");
                        console.log(this.productos);
                        this.otSeleccionadaBool = true;
                    })
                    
                }
            }
        }
    }
</script>

<style scoped>
    .color{
        margin-top:  20px;
        background-color:#3c70a4;
        border-color: #64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
    }
    .color2{
        margin-top:  20px;
        background-color:#ffffff;
        border-color: 64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
        color: #3c70a4;
    }
    .lavelFont{
        font-size: 20px;
        color: #da9833;
    }
    .colorNav{
        background-color: 64b2cd;
    }
    .h2{
        color: #3c70a4;
    }
    .colorBoton{
        background-color: da9833;
    }
</style>


