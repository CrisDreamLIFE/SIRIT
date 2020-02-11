<template>  <!-- <button  @click="botonSobreOt" type="button" class="btn btn-info btn-lg btn-block">Function one</button> -->
    <div class="container">
        <h3>Reportes: {{opcionSeleccionada}}</h3>  
        <br>
        <button  @click="botonSobreOt" type="button" class="btn btn-secondary btn-lg btn-block">Reportes sobre OT</button>
        <br> 
        <div v-if="otBool" class="row container color4">
            <div class="col-md-2">
                <input class="form-check-input" :value="true" :unchecked-value="true" v-model="abierta" id="abierta" type="checkbox">
                <label style="font-size:18px" for = "abierta">{{'   Abiertas'}}</label>
                <br>
                <input class="form-check-input" :value="true" :unchecked-value="true" v-model="cerrada" id="cerrada" type="checkbox">
                <label style="font-size:18px" for = "cerrada">{{'   Cerradas'}}</label> 
            </div>  
            <div class="col-md-4">
                <label  class= "color4" for="select1">Exportar Por:</label>
                <select id="select1" v-model="opcionSeleccionada" class="form-control">
                    <option value="1" >Todas</option>
                    <option value="2" >Número de OT</option> 
                    <option value="3" >Fecha de OC</option>
                    <option value="4" >Fecha de Entrega</option>
                    <option value="5" >País</option>
                    <option value="6" >Cliente</option>
                    <option value="7" >Código Siom</option>
                    <option value="8" >Responsable</option>
                </select>
            </div>
            <!-- aqui se ponen los input y select-->
            <div class="col-md-6">
                <div v-if="opcionSeleccionada==2">
                    <div class="row">
                        <div class="col-md-6">
                            <label  class= "color4" for="2">Operacion:</label>   
                            <select id="2" v-model="opcionSeleccionada2" class="form-control">
                                <option value="1">Igual a:</option>
                                <option value="2">Mayor a:</option>
                                <option value="3">Menor a:</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label  class= "color4" for="2-1">OT:</label>
                            <input type="text" class="form-control" id="2-1" v-model="ot">
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==3">
                    <div class="row">
                        <div class="col-md-6">
                            <label  class= "color4" for="3">Operacion:</label>   
                            <select id="3" v-model="opcionSeleccionada3" class="form-control">
                                <option value="1">Igual a:</option>
                                <option value="2">Mayor a:</option>
                                <option value="3">Menor a:</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label  class= "color4" for="3-1">Fecha OC:</label>
                            <input type="date" class="form-control" id="3-1" v-model="fecha_oc">
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==4">
                    <div class="row">
                        <div class="col-md-6">
                            <label  class= "color4" for="4">Operacion:</label>   
                            <select id="4" v-model="opcionSeleccionada4" class="form-control">
                                <option value="1">Igual a:</option>
                                <option value="2">Mayor a:</option>
                                <option value="3">Menor a:</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label  class= "color4" for="4-1">Fecha OC:</label>
                            <input type="date" class="form-control" id="4-1" v-model="fecha_entrega">
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==5">
                    <div class="row">
                        <div class="col-md-6">
                            <label  class= "color4" for="5">País:</label>   
                            <select id="5" v-model="opcionSeleccionada5" class="form-control">
                                <option value="1">Chile</option>
                                <option value="2">Perú</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==6">
                    <div class="row">
                        <div class="md-form col-md-6">
                            <label  class= "color4" for="6">Cliente:</label>  
                           <!-- <input type="search" id="6" class="form-control mdb-autocomplete">-->
                            <select class="mdb-select" searchable="Search here..">
  <option value="1" disabled selected>Choose your option</option>
  <option value="2" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-1.jpg" class="rounded-circle">
    example
    1</option>
  <option value="3" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-2.jpg" class="rounded-circle">
    example
    2</option>
  <option value="4" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-3.jpg" class="rounded-circle">
    example
    1</option>
</select>

                            <!--<select id="6" v-model="opcionSeleccionada6" class="form-control">
                                <option v-for="(cliente,index) in clientes" v-bind:key="index" v-bind:value="cliente.id">
                                    {{cliente.nombre}}
                                </option>
                            </select> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- columna del boton -->
            <div class="col-md-4"></div>
            <div  class="col-md-4">
                <br>
                <div v-if="(opcionSeleccionada==1) || (ot!='' && opcionSeleccionada==2) || 
                (fecha_oc!='' && opcionSeleccionada==3) || (fecha_entrega!='' && opcionSeleccionada==4)||
                (opcionSeleccionada==5 && opcionSeleccionada5!='')||(opcionSeleccionada==6 && opcionSeleccionada6!='' && clientes!=null)">
                <button  @click="botonSobreOt" type="button" class="btn btn-success btn-lg btn-block">Exportar</button></div><br>    
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
        props: ['clientes'], 
        data(){
            return {
                otBool: false,
                abierta: true,
                cerrada: false,
                opcionSeleccionada:1,
                opcionSeleccionada2: 1,
                opcionSeleccionada3: 1,
                opcionSeleccionada4: 1,
                opcionSeleccionada5: 1,
                opcionSeleccionada6: 1,
                ot:'',
                fecha_oc:'',
                fecha_entrega:''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            botonSobreOt(){
                console.log("dfsa")
                if(this.otBool== true){
                    this.otBool= false;
                    return 1;
                }
                else{
                    console.log("dfsa");
                    this.otBool= true;
                    return 1;
                }
            }
        } 
    }
</script>