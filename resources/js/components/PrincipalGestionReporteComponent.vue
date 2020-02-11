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
                            <select id="6" v-model="opcionSeleccionada6" class="form-control">
                                <option v-for="(cliente,index) in clientes" v-bind:key="index" v-bind:value="cliente.id">
                                    {{cliente.nombre}}
                                </option>
                            </select> 
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==7">
                    <div class="row">
                        <div class="md-form col-md-6">
                            <label  class= "color4" for="7">Código Siom:</label>    
                                <input id="7" class="form-control" type="text" v-model="searchProducto" @input="onChangueProducto" @blur="loseFocusProducto" />
                                <ul v-show="isOpenProducto" class="autocomplete-results">
                                    <li @click="setResultProducto(result)" v-for="(result,i) in resultsProducto" :key="i" class="autocomplete-result">{{result.codigo_siom}}</li>
                                </ul>
                        </div>
                    </div>
                </div>
                <div v-if="opcionSeleccionada==8">
                    <div class="row">
                        <div class="md-form col-md-6">
                            <label  class= "color4" for="8">Responsable:</label>  
                                <input id="8" class="form-control" type="text" v-model="searchResponsable" @input="onChangueResponsable" />
                                <ul v-show="isOpenResponsable" class="autocomplete-results">
                                    <li @click="setResultResponsable(result)" v-for="(result,i) in resultsResponsable" :key="i" class="autocomplete-result">{{result}}</li>
                                </ul>
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
                (opcionSeleccionada==5 && opcionSeleccionada5!='')||(opcionSeleccionada==6 && opcionSeleccionada6!='' && clientes!=null)||
                (opcionSeleccionada==7 && searchProducto!='')">
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
        props: ['clientes','productos','responsables'], 
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
                opcionSeleccionada7: 1,
                ot:'',
                fecha_oc:'',
                fecha_entrega:'',               
                //OPCION 2
                    searchOt: '',
                    resultsOt: '',
                    isOpenOt: false,
                //OPCION 7
                    searchProducto: '',
                    resultsProducto: '',
                    isOpenProducto: false,
                //OPCION 8
                    searchResponsable: '',
                    resultsResponsable: '',
                    isOpenResponsable: false,
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
            },
            //OPCION 2
            onChangueOt(){
                this.isOpenOt=true;
                this.filterResultsOt();
            },
            filterResultsOt(){
                this.resultsoT = this.ots.filter(item => item.toLowerCase().indexOf(this.searchOt.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
            setResultOt(result){
                this.searchOt = result.id;
                this.isOpenOt = false;
            },
            loseFocusOt(){
                this.isOpenOt = false;
            },
            //OPCION 7
            onChangueProducto(){
                console.log(this.productos);
                this.isOpenProducto=true; //este igual hacer otro
                this.filterResultsProducto();
            },
            filterResultsProducto(){
                console.log(this.productos);
                this.resultsProducto = this.productos.filter(item => item.codigo_siom.toLowerCase().indexOf(this.searchProducto.toLowerCase())>-1);
            },
            setResultProducto(result){
                this.searchProducto = result.codigo_siom;
                this.isOpenProducto = false;
            },
            loseFocusProducto(){
                this.isOpenProducto = false;
            },
            //OPCION 8
            onChangueResponsable(){
                this.isOpenResponsable=true;
                this.filterResultsResponsable();
            },
            filterResultsResponsable(){
                this.resultsResponsable = this.items.filter(item => item.toLowerCase().indexOf(this.search.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
            setResultResponsable(result){
                this.searchResponsable = result.nombre;
                this.isOpenResponsable = false;
            },
            loseFocusResponsable(){
                this.isOpenResponsable = false;
            },
        } 
    }
</script>

<style >
  .autocomplete {
    position: relative;
    width: 300px;
  }

  .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid black  ;
    height: 120px;
    overflow: auto;
    background-color:white  
  }

  .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
  }

  .autocomplete-result:hover {
    background-color: #64b2cd;
    color: white;
  }
</style>