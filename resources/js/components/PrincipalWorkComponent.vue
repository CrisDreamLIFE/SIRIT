<template>

        <!-- Just an image -->
    <div class= "container todo">
        <!-- si boton continuarEesumen
        mostrar el resumnen-->
        <div v-if="botonResumen">
            <br>
            <h2 class="h2">Resumen del Trabajo:</h2>
            <br>
            <div class="row">
                    <div class="col-sm-2">
                        <h3 class="h3">OT:</h3>
                    </div>
                    <div class="col-sm-5">
                        <h3 class="h3">Producto:</h3>
                    </div>
                    <div class="col-sm-5">
                        <h3 class="h3">Sub-Producto:</h3>
                    </div>
            </div>
            <div class="container color2">
                <div class="row" >
                    <div class="col-sm-12">
                        <br>
                        <div v-for="(linea,index) in otProducto" v-bind:key="index">
                            <div v-for="(sub,indexS) in otProducto[index][2]" v-bind:key="indexS">
                                <div class="row">
                                    <div class="col-sm-2">
                                    <p>* {{otProducto[index][0].id}}</p>
                                    </div> 
                                    <div class="col-sm-5">
                                    <p>{{otProducto[index][1].nombre}}</p>
                                    </div>
                                    <div class="col-sm-5">
                                    <p>{{otProducto[index][2][indexS].nombre}}</p>
                                    </div>
                                </div>
                                <hr class="style3">
                            </div>    
                        </div>
                    </div>   
                </div> 
            </div>
            <br><br>
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="h3">Trabajador:</h3>
                </div>
                <div class="col-sm-6">
                    <h3 class="h3">Proceso:</h3>
                </div>
            </div>
            <div class="row">
                <div class="col col-sm-6">
                    <div class="container color2">
                        <br>
                        <div v-for="(trabajador,index) in trabajadoresSeleccionados" v-bind:key="index">
                            <p>* {{trabajador.nombre}}</p> 
                        </div>
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="container color2">
                        <br>
                        <div v-for="(proceso,index) in procesosSeleccionados" v-bind:key="index">
                            <p>* {{procesos[proceso].nombre}}</p> 
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row  colorBoton">
                <button type="button" v-on:click= "atrasResumen()" class="btn btn-secondary btn-lg colorBoton">Atrás</button>
            </div>
            <br>
            <div>
                <h2 class="h2">Tiempo de Trabajo</h2>
                <p id="hms" class= "h3 ">00:00:00</p>
            </div>
            <div class="container">
                <div class="row justify-content-md-center colorBoton">
                    <div class="col col-sm-6">
                        <button type="button" v-on:click= "comenzarTrabajo()" class="btn btn-success btn-lg colorBoton">Comenzar</button>
                    </div>
                    <div class="col col-sm-6 ">
                        <button data-toggle="modal" data-target="#exampleModal" :disabled="!trabajoComenzado" type="button" v-on:click= "terminarTrabajo()" class="btn btn-danger btn-lg colorBoton">Terminar</button>             
                    </div>
                    <!-- Modal -->
                    <div v-if="botonTerminar" class="modal fade aa" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Trabajo Finalizado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" v-for="(linea,indexG) in otProducto" v-bind:key="indexG">
                                <label for="">OT {{otProducto[indexG][0].id}} PRODUCTO {{otProducto[indexG][1].nombre}}</label>

                                <div class="container" v-for="(subProd,indexM) in otProducto[indexG][2]" v-bind:key="indexM">
                                    <label for="">{{subProd.nombre}}</label>
                                    
                                    <div class="container" v-for="(proceso,index) in procesosSeleccionados" v-bind:key="index">
                                            <div class="row container">
                                                <div class="col col-sm-4">
                                                    {{procesos[index].nombre}} {{proceso.nombre}} 
                                                </div>
                                                <div class="col col-sm-8" >
                                                    <div class="row">
                                                        <div class="col col-sm-6">
                                                            <label for="">Cantidad:</label>
                                                        </div>
                                                        <div class="col col-sm-5">
                                                            <input onkeypress="solonumeros(event);" min="1" pattern="^[0-9]+" type="number" v-model="cantidadProcesos[indexG][indexM][index]" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                    </div>
                                    <div class="row" v-if="otProducto[indexG][1].tipo_material_id==filtradoMaterial">
                                        <div class="col col-xl-2">
                                            Pieza N°:
                                        </div>
                                        <div v-for="n in cantidadesProductos[indexG]" v-bind:value="n" v-bind:key="n" class="form-check-inline">  <!--:id="index+pro.nombre+otProducto[indexG][2][indexM].nombre + otProducto[indexG][0].id -->
                                            <input class="form-check-input" type="checkbox" :id="n+procesos[indexM].id"  :value="n" v-model="aux[indexG][indexM]"> <!--valor for mas arriba -->
                                            <label class="form-check-label" :for="n+procesos[indexM].id">
                                                {{n}}
                                            </label>
                                            <br>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary"  v-on:click= "guardarTrabajo()" >Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <br>
            <h2 class="h2">Especificaciones del Trabajo:</h2>
            <div v-if="botonContinuar">
               
                <form>
                    <div class="form-group">
                        <div v-for="(combinacion,indexG) in otProducto" v-bind:key="indexG">
                            <h3 class="h3">Seleccion sub-productos de: OT {{otProducto[indexG][0].id}}- {{otProducto[indexG][1].nombre}}</h3>
                            <div class="container color">  <!-- este 0 deberia ser el index del for de arriba -->
                                <div v-for="(sub,index) in subProductos[indexG]" v-bind:key="index" class="form-check-inline">  <!--aqui va el otro for -->
                                    <input class="form-check-input" type="checkbox" :id="index+indexG*sub.id+sub.nombre" :value="subProductos[indexG][index]" v-model="otProducto[indexG][2]"> <!--valor for mas arriba -->
                                    <label class="form-check-label lavelFont2" :for="index+indexG*sub.id+sub.nombre" >
                                        {{sub.nombre}} 
                                    </label>
                                    <br>
                                </div>  
                            </div>
                            <br><br>
                        </div>
                        <h3 class="h3">Seleccion de Procesos a realizar:</h3>
                        <div class="container color">  
                                <div v-for="(proceso,indexP) in procesos" v-bind:key="indexP" v-bind:value="procesos[indexP].id"  class="form-check-inline">  <!--aqui va el otro for -->
                                    <input class="form-check-input" type="checkbox" :id="indexP+proceso.id+proceso.nombre" :value="indexP"   v-model="procesosSeleccionados"> <!--valor for mas arriba -->
                                    <label class="form-check-label lavelFont2" :for="indexP+proceso.id+proceso.nombre" >
                                    {{proceso.nombre}}   
                                    </label>
                                </div> 
                                <br>
                        </div>
                    </div>
                </form>
                <div class="row  colorBoton">
                <button type="button" v-on:click= "atrasSubProductos()" class="btn btn-secondary btn-lg colorBoton">Atrás</button>
                </div>
                <br><br>
                <div class="row justify-content-center colorBoton">
                    <button type="button" v-on:click= "continuarResumen()" class="btn btn-block btn-success btn-lg colorBoton">CONTINUAR</button>
                </div>
            </div> 
            <div v-else> 
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
                                    <option v-for="(trabajador,index) in trabajadores" v-bind:key="index" v-bind:value="index">
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
                                <div class="col-sm-6">
                                    <select  v-model="otSeleccionada" @change="onChangeOt()" class="form-control" >
                                    <option disabled selected >orden de trabajo</option>
                                    <option v-for="(ot,index) in ots" v-bind:key="index" v-bind:value="index">
                                        {{ ot.id }}
                                    </option>
                                    </select>     
                                </div>
                                    <div class="col-sm-5">
                                        <select  :disabled="!otSeleccionadaBool" v-model="productoSeleccionado" class="form-control" >
                                        <option disabled selected >Productos</option>
                                        <option v-for="(producto, index) in productos" v-bind:key="index" v-bind:value="index">
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
                        <h3 class="h3">OT seleccionada:</h3>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="h3">Producto seleccionado:</h3>
                    </div>
                </div>
                <div class="container color2">
                    <div class="row">
                        <div class="col-sm-6">
                            <br>
                            <div v-for="(linea,index) in otProducto" v-bind:key="index">
                                <p>* OT {{otProducto[index][0].id}}</p>
                            </div>    
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <div v-for="(linea,index) in otProducto" v-bind:key="index">
                                <p>* {{otProducto[index][1].nombre}}</p> 
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row justify-content-center colorBoton">
                    <button type="button" v-on:click= "continuarClick()" class="btn btn-block btn-success btn-lg colorBoton">CONTINUAR</button>
                </div>
                <br><br>
                <br><br><br>
            </div>
        </div>
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
                productosSeleccionados: [],
                botonContinuar: false,
                botonResumen:false,
                botonTerminar: false,
                trabajoComenzado: false,
                otProducto: [],
                subProductos: [],
                procesos: [],
                procesosSeleccionados:[],
                aux:[],
                aux2: [],
                h: 0,
                m: 0,
                s: 0,
                id_sesion: null,
                filtradoMaterial: null,
                cantidadesProductos: [],
                cantidadProcesos: []
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
            escribir(){
                var hAux, mAux, sAux;
                this.s++;
                if (this.s>59){this.m++;this.s=0;}
                if (this.m>59){this.h++;this.m=0;}
                if (this.h>24){this.h=0;}
                if (this.s<10){sAux="0"+this.s;}else{sAux=this.s;}
                if (this.m<10){mAux="0"+this.m;}else{mAux=this.m;}
                if (this.h<10){hAux="0"+this.h;}else{hAux=this.h;}

                document.getElementById("hms").innerHTML = hAux + ":" + mAux + ":" + sAux;
            },
            comenzarTrabajo(){
               //console.log(".-.")
                document.getElementById("hms").innerHTML="00:00:00";
                this.escribir();
                setInterval(this.escribir,1000);
                //post de sesion
                var params = {
                    id_estacion: this.estacionSeleccionada,
                    trabajadores: this.trabajadoresSeleccionados
                };
                console.log(params);
                axios
                    .post('http://localhost:8000/sesion', params)
                    .then(response => {
                        this.id_sesion = response.data;
                        console.log(this.id_sesion);})
                var productosSelec = {
                    todo: this.otProducto
                };
                console.log(productosSelec);
                axios
                    .post('http://localhost:8000/cantidadProducto', productosSelec)
                    .then(response => {
                        this.cantidadesProductos = response.data;
                        this.trabajoComenzado = true;
                        console.log(this.cantidadesProductos);})
                //Obtener las piezas de cada producto
                //subProducto->producto->ot-producto('cantidad') perfecto
                //otProducto[[ot,producto,subs], [ot2,producto2,subs2], [ot3,producto3,subs3]]
                //send[o, producto 4, productoX] -> return:  [cantidad1, cantidad4, cantidadX]

            },
            terminarTrabajo(){
               // this.aux = [ot,producto, ]
                this.botonTerminar = true;    
            },
            guardarTrabajo(){
                if(this.aux == this.aux2){
                    toastr.error("No ha ingresado Nombre","Aviso!");
                        return false;
                    }
                var otResumen = []
                for (var p = 0; p < this.otProducto.length; p++) {
                    if(!otResumen.includes(this.otProducto[p][0].id)){
                        otResumen.push(this.otProducto[p][0].id);
                    }
                }

                var procesosSend = []
                for (var p = 0; p < this.procesosSeleccionados.length; p++) {
                    procesosSend.push(this.procesos[this.procesosSeleccionados[p]].id);
                }
                console.log("piezas[0][0]:" + this.aux[0][0]);
                console.log("cantidadProcesos[0][0][0]:" + this.cantidadProcesos[0][0][0]);
                var params = {
                    id_sesion: this.id_sesion,
                    otProducto: this.otProducto,
                    procesos: procesosSend,
                    piezas: this.aux,
                    cantidadProcesos: this.cantidadProcesos,
                    ots: otResumen
                    //agregar las cantidades y tipo de pieza:
                };
                console.log(params);
                axios
                    .post('http://localhost:8000/sesionFinal', params)
                    .then(response => {
                        console.log("guarde toda la basura");
                        location.reload();})
            },
            atrasSubProductos(){
                this.botonContinuar = false;
            },
            atrasResumen(){
                this.botonResumen = false;
            },
            continuarClick(){ 
                axios
                .get('http://localhost:8000/tipoMaterialFiltrador')
                .then(response => {
                    this.filtradoMaterial = response.data;
                    this.botonContinuar = true;
                    })
                console.log("procesosSeleccionados.lenght:");
                console.log(this.otProducto.length);
                //esto debe ser por subProducto :V       
            },
            continuarResumen(){
                /*Se debe cargar un componente extra, quitar estos y poner el otro, ooo, lo que
                lo haria mas rapido es ponero igual en esta vista, lo cuual tendria sentido pero
                le chantamos unos if para verlo, en todo caso no es mucho, asi que hagamos eso :) */
                /*var otResumen = []
                for (var p = 0; p < this.otProducto.length; p++) {
                    console.log("for")
                    if(!otResumen.includes(this.otProducto[p][0].id)){
                        console.log("if")
                        otResumen.push(this.otProducto[p][0].id);
                        console.log("otProducti[0][0].id= " + this.otProducto[p][0].id)
                    }
                    console.log("otResumen[p]: "+ otResumen[p])
                }
                for (var l = 0; l < otResumen.length; l++) {
                    console.log("AUX ::::")
                    console.log(this.aux)
                    this.aux.push([])
                    this.cantidadProcesos.push([]);
                    console.log("aux1 = ") 
                    var poner = 0;
                    for (var i = 0; i < this.otProducto.length; i++) {
                        console.log("tResumen[l] = " + otResumen[l])
                        console.log(" this.otProducto[l] = " +  this.otProducto[i][0].id)
                        if(otResumen[l]== this.otProducto[i][0].id){
                            
                            console.log("aux3 = ")
                            this.aux[l].push([]);
                            this.cantidadProcesos[l].push([]);
                            for (var j = 0; j < this.otProducto[i][2].length; j++) {
                                console.log("aux4 = ")
                                this.aux[l][i-poner].push([]);   
                                this.cantidadProcesos[l][i-poner].push([]);
                                for (var k = 0; k < this.procesosSeleccionados.length; k++) {
                                    console.log("aux5 = ")
                                    this.aux[l][i-poner][j].push([]);
                                    this.cantidadProcesos[l][i-poner][j].push([]);    
                                } 
                            }
                        }
                        else{
                            poner = poner+1;
                        }
                        
                    }
                }*/
                for (var i = 0; i < this.otProducto.length; i++) {
                    console.log("for1");
                    this.cantidadProcesos.push([]);
                    this.aux.push([]);
                    this.aux2.push([]);
                    for (var j = 0; j < this.otProducto[i][2].length; j++){
                        console.log("for1");
                        this.cantidadProcesos[i].push([]);
                        this.aux[i].push([]);
                        this.aux2[i].push([]);
                        console.log("cantidadProcesos:")
                        console.log(this.cantidadProcesos);
                        for (var k = 0; k < this.procesosSeleccionados.length; k++){
                            this.cantidadProcesos[i][j].push([]);

                        }

                    }
                }
                    
                this.botonResumen = true;
            },
            agregarTrabajador(){
                if(!this.trabajadoresSeleccionados.includes(this.trabajadores[this.trabajadorSeleccionado])){
                    this.trabajadoresSeleccionados.push(this.trabajadores[this.trabajadorSeleccionado])
                }
            },
            agregarProducto(){
              //  this.productosSeleccionados.push(this.productos[this.productoSeleccionado]);
               // this.otsSeleccionadas
                var combinacion = [];
                console.log("antes del push")
                combinacion.push(this.ots[this.otSeleccionada]);  //ot completa
                combinacion.push(this.productos[this.productoSeleccionado]); //producto completo
                //this.productosSeleccionados.push(this.productos[this.productoSeleccionado].id);
                console.log()
                //hacer un push  de las subproductos del producto seleccionado
                var subProductos= null;
                axios
                    .get('http://localhost:8000/subProductos/'+this.productos[this.productoSeleccionado].id)
                    .then(response => {
                        console.log("post response");
                        subProductos = response.data;
                        combinacion.push([]);
                        console.log(subProductos);
                        this.otProducto.push(combinacion);
                        
                        this.subProductos.push(subProductos);
                        console.log("hice todos los push:");})  //RECORDAR ELIMINAR ESTO MISMO CUANDO SE BORRE UN PRODUCTO, OT, ETC     
            },
            onChangeEstación(){
                var i;
                var index = -1;
                if(this.estacionSeleccionada != null){
                    console.log("el valor de index: ")
                    console.log(index)
                    axios
                    .get('http://localhost:8000/trabajadores/'+this.estacionSeleccionada)
                    .then(response => {
                        this.trabajadores = response.data
                        console.log(this.trabajadores);
                        this.estacionSeleccionadaBool = true;})
                    
                    axios
                    .get('http://localhost:8000/procesos/'+this.estacionSeleccionada)
                    .then(response => {
                        this.procesos = response.data;})
                }
            },
            solonumeros(e){
                var key = window.event ? e.which : e.keyCode;
                if(key < 48 || key > 57){
                    e.preventDefault();
                }
            },
            onChangeOt(){
                if(this.otSeleccionada != null){
                    console.log("ot seleccionada: ")
                    console.log(this.otSeleccionada)
                    axios
                    .get('http://localhost:8000/productosOt/'+this.ots[this.otSeleccionada].id)
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
    .lavelFont2{
        font-size: 20px;
        color: white;
    }
    .colorNav{
        background-color: 64b2cd;
    }
    .h2{
        color: #3c70a4;
    }
    .aa{
        color: #000;
    }
    .h3{
        color: #da9833;
    }
    .colorBoton{
        color: white;
    }
    .style3{
        border-top: 1px dashed #8c8b8b;
    }
</style>


