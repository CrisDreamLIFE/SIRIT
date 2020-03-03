<template>  <!-- <button  @click="botonSobreOt" type="button" class="btn btn-info btn-lg btn-block">Function one</button> -->
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-2"><!--colorBoton-->
                <button type="button" v-on:click="volverMenu" class="btn btn-secondary  btn-block colorBoton">Atrás</button>
            </div>
        </div>
        <br>
        <h3>Reportes:</h3>  
        <br>
        <button  @click="botonSobreOt" type="button" class="btn btn-primary btn-lg btn-block">Reportes sobre OT</button>
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
                        <option value="9" >Tipo de OT</option>
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
                                <input id="2-1" class="form-control" type="text" v-model="searchOt" @input="onChangueOt"/>
                                    <ul v-show="isOpenOt" class="autocomplete-results">
                                        <li  @click="setResultOt(result)" v-for="(result,i) in resultsOt" :key="i" class="autocomplete-result">{{result.id}}</li>
                                    </ul>          
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
                                <input id="6" class="form-control" type="text" v-model="searchCliente" @input="onChangueCliente" />
                                <ul v-show="isOpenCliente" class="autocomplete-results">
                                    <li @click="setResultCliente(result)" v-for="(result,i) in resultsCliente" :key="i" class="autocomplete-result">{{result.nombre_cliente}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionada==7">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="7">Código Siom:</label>    
                                    <input id="7" class="form-control" type="text" v-model="searchProducto" @input="onChangueProducto"/>
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
                                        <li @click="setResultResponsable(result)" v-for="(result,i) in resultsResponsable" :key="i" class="autocomplete-result">{{result.nombre_usuario}}</li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionada==9">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <label  class= "color4" for="9">Tipo de OT:</label>
                                    <multiselect v-model="searchTipo" :options="tipos" deselect-label="Presiona para Quitar" select-label="Presiona para seleccionar" :multiple="true" :clear-on-select="false" :close-on-select="false" :custom-label="nameWithLang" placeholder="Seleccione al menos una" label="nombre_tipo" track-by="nombre_tipo"></multiselect>
                                
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- columna del boton -->
                <div class="col-md-4"></div>
                <div  class="col-md-4">
                    <br>
                    <div v-if="(opcionSeleccionada==1) || (opcionSeleccionada==2 && searchOt!=''  && ots!=null) || 
                    (fecha_oc!='' && opcionSeleccionada==3) || (fecha_entrega!='' && opcionSeleccionada==4)||
                    (opcionSeleccionada==5 && opcionSeleccionada5!='')||(opcionSeleccionada==6 && searchCliente!='' && clientes!=null)||
                    (opcionSeleccionada==7 && searchProducto!='' && productos!=null)||(opcionSeleccionada==8 && searchResponsable!='' && responsables!=null )||
                    (opcionSeleccionada==9 && searchTipo!='' && tipos!=null )">
                    <button  @click="clickExportar" type="button" class="btn btn-success btn-lg btn-block">Exportar</button></div><br>    
                </div>       
            </div>  
        <button  @click="botonSobreSesiones" type="button" class="btn btn-primary btn-lg btn-block">Reportes sobre Sesiones de Trabajo</button>
            <br>
            <div v-if="sesionBool" class="row container color4">
                <div class="col-md-4">
                    <label  class= "color4" for="select2">Exportar Por:</label>
                    <select id="select2" v-model="opcionSeleccionadaSesion" class="form-control">
                        <option value="1" >Todas</option>
                        <option value="2" >Número de OT</option> 
                        <option value="3" >Fecha</option>
                        <option value="4" >Área</option>
                        <option value="5" >Estación</option>
                        <option value="6" >Nave</option>
                        <option value="7" >En Proceso</option>
                        <option value="8" >Código Siom</option>
                    </select>
                </div>
                <!-- SESIOON  aqui se ponen los input y select-->
                <div class="col-md-8">
                    <div v-if="opcionSeleccionadaSesion==2">
                        <div class="row">
                            <div class="col-md-6">
                                <label  class= "color4" for="Sesion2">Operacion:</label>   
                                <select id="Sesion2" v-model="opcionSeleccionadaSesion2" class="form-control">
                                    <option value="1">Igual a:</option>
                                    <option value="2">Mayor a:</option>
                                    <option value="3">Menor a:</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label  class= "color4" for="Sesion2-1">OT:</label>
                                <input id="Sesion2-1" class="form-control" type="text" v-model="searchSesionOt" @input="onChangueSesionOt"/>
                                    <ul v-show="isOpenSesionOt" class="autocomplete-results">
                                        <li  @click="setResultSesionOt(result)" v-for="(result,i) in resultsSesionOt" :key="i" class="autocomplete-result">{{result.id}}</li>
                                    </ul>          
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionadaSesion==3">
                        <div class="row">
                            <div class="col-md-6">
                                <label  class= "color4" for="sesion3">Operacion:</label>   
                                <select id="sesion3" v-model="opcionSeleccionadaSesion3" class="form-control">
                                    <option value="1">Igual a:</option>
                                    <option value="2">Mayor a:</option>
                                    <option value="3">Menor a:</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label  class= "color4" for="sesion3-1">Fecha:</label>
                                <input type="date" class="form-control" id="sesion3-1" v-model="fecha_sesion">
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionadaSesion==4">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="sesion4">Área:</label>   
                                <input id="sesion4" class="form-control" type="text" v-model="searchSesionArea" @input="onChangueSesionArea" />
                                <ul v-show="isOpenSesionArea" class="autocomplete-results">
                                    <li @click="setResultSesionArea(result)" v-for="(result,i) in resultsSesionArea" :key="i" class="autocomplete-result">{{result.nombre_area}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>  
                    <div v-if="opcionSeleccionadaSesion==5">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="sesion5">Estacion:</label>   
                                <input id="sesion5" class="form-control" type="text" v-model="searchSesionEstacion" @input="onChangueSesionEstacion" />
                                <ul v-show="isOpenSesionEstacion" class="autocomplete-results">
                                    <li @click="setResultSesionEstacion(result)" v-for="(result,i) in resultsSesionEstacion" :key="i" class="autocomplete-result">{{result.codigo}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionadaSesion==6">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="sesion6">Nave:</label>   
                                <input id="sesion6" class="form-control" type="text" v-model="searchSesionNave" @input="onChangueSesionNave" />
                                <ul v-show="isOpenSesionNave" class="autocomplete-results">
                                    <li @click="setResultSesionNave(result)" v-for="(result,i) in resultsSesionNave" :key="i" class="autocomplete-result">{{result.nombre_nave}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div v-if="opcionSeleccionadaSesion==8">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="sesion8">Código Siom:</label>   
                                <input id="sesion8" class="form-control" type="text" v-model="searchSesionCodigo" @input="onChangueSesionCodigo" />
                                <ul v-show="isOpenSesionCodigo" class="autocomplete-results">
                                    <li @click="setResultSesionCodigo(result)" v-for="(result,i) in resultsSesionCodigo" :key="i" class="autocomplete-result">{{result.codigo_siom}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div  class="col-md-4"></div>
                <div  class="col-md-4">
                    <br>
                    <div v-if="opcionSeleccionadaSesion==1 || (opcionSeleccionadaSesion==2 && searchSesionOt!='' && ots!=null)||
                    (fecha_sesion!='' && opcionSeleccionadaSesion==3) || (opcionSeleccionadaSesion==4 && searchSesionArea!='' && areas!=null)
                    ||(opcionSeleccionadaSesion==5 && searchSesionEstacion!='' && estaciones!=null)||(opcionSeleccionadaSesion==6 && searchSesionNave!='' && naves!=null)
                    || (opcionSeleccionadaSesion==7)||(opcionSeleccionadaSesion==8 && searchSesionCodigo!='' && productos!=null) ">
                    <button  @click="clickExportarSesion" type="button" class="btn btn-success btn-lg btn-block">Exportar</button></div><br>    
                </div>  
            </div>
        <button  @click="botonSobreTrabajadores" type="button" class="btn btn-primary btn-lg btn-block">Listado de Trabajadores</button>
            <br>
            <div v-if="trabajadorBool" class="row container color4">
                <div class="col-md-4">
                    <label  class= "color4" for="select3">Exportar Por:</label>
                    <select id="select3" v-model="opcionSeleccionadaTrabajador" class="form-control">
                        <option value="1" >Todos</option>
                        <option value="2" >Área</option> 
                    </select>
                </div>
                <!-- TRABAJADOOOR  aqui se ponen los input y select-->
                <div class="col-md-8">
                    <div v-if="opcionSeleccionadaTrabajador==2">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="trabajador2">Área:</label>   
                                <input id="trabajador2" class="form-control" type="text" v-model="searchTrabajadorArea" @input="onChangueTrabajadorArea" />
                                <ul v-show="isTrabajadorArea" class="autocomplete-results">
                                    <li @click="setResultTrabajadorArea(result)" v-for="(result,i) in resultsTrabajadorArea" :key="i" class="autocomplete-result">{{result.nombre_area}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>    
                </div>
                <div  class="col-md-4"></div>
                <div  class="col-md-4">
                    <br>
                    <div v-if="opcionSeleccionadaTrabajador==1 || (opcionSeleccionadaTrabajador==2 && searchTrabajadorArea!='' && areas!=null)">
                        <button  @click="clickExportarTrabajador" type="button" class="btn btn-success btn-lg btn-block">Exportar</button>
                    </div> <br>   
                </div>
            </div>
        <button  @click="botonSobreEstaciones" type="button" class="btn btn-primary btn-lg btn-block">Listado de Estaciones</button>
            <br>
            <div v-if="estacionBool" class="row container color4">
                <div class="col-md-4">
                    <label  class= "color4" for="select4">Exportar Por:</label>
                    <select id="select4" v-model="opcionSeleccionadaEstacion" class="form-control">
                        <option value="1" >Todas</option>
                        <option value="2" >Área</option> 
                    </select>
                </div>
                <div class="col-md-8"></div>
                <!-- Usuario  aqui se ponen los input y select
                <div class="col-md-8">
                    <div v-if="opcionSeleccionadaTrabajador==2">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="trabajador2">Área:</label>   
                                <input id="trabajador2" class="form-control" type="text" v-model="searchTrabajadorArea" @input="onChangueTrabajadorArea" />
                                <ul v-show="isTrabajadorArea" class="autocomplete-results">
                                    <li @click="setResultTrabajadorArea(result)" v-for="(result,i) in resultsTrabajadorArea" :key="i" class="autocomplete-result">{{result.nombre_area}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>    
                </div>-->
                <div  class="col-md-4"></div>
                <div  class="col-md-4">
                    <br>
                    <div v-if="opcionSeleccionadaEstacion==1 ">
                        <button  @click="clickExportarEstacion" type="button" class="btn btn-success btn-lg btn-block">Exportar</button>
                    </div> <br>   
                </div>
            </div>  
        <button  @click="botonSobreUsuarios" type="button" class="btn btn-primary btn-lg btn-block">Listado de Usuarios</button>
            <br>
            <div v-if="usuarioBool" class="row container color4">
                <div class="col-md-4">
                    <label  class= "color4" for="select5">Exportar Por:</label>
                    <select id="select5" v-model="opcionSeleccionadaUsuario" class="form-control">
                        <option value="1" >Todos</option>
                        <option value="2" >Rol</option> 
                    </select>
                </div>
                <div class="col-md-8"></div>
                <!-- Usuario  aqui se ponen los input y select
                <div class="col-md-8">
                    <div v-if="opcionSeleccionadaTrabajador==2">
                        <div class="row">
                            <div class="md-form col-md-6">
                                <label  class= "color4" for="trabajador2">Área:</label>   
                                <input id="trabajador2" class="form-control" type="text" v-model="searchTrabajadorArea" @input="onChangueTrabajadorArea" />
                                <ul v-show="isTrabajadorArea" class="autocomplete-results">
                                    <li @click="setResultTrabajadorArea(result)" v-for="(result,i) in resultsTrabajadorArea" :key="i" class="autocomplete-result">{{result.nombre_area}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>    
                </div>-->
                <div  class="col-md-4"></div>
                <div  class="col-md-4">
                    <br>
                    <div v-if="opcionSeleccionadaUsuario==1 ">
                        <button  @click="clickExportarUsuario" type="button" class="btn btn-success btn-lg btn-block">Exportar</button>
                    </div> <br>   
                </div>
            </div>    
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    // register globally
    Vue.component('multiselect', Multiselect)
    export default {
        components: { Multiselect },
        props: ['ots','clientes','productos','responsables','tipos','estaciones','areas','naves'], 
        data(){
            return {
                otBool: false,
                sesionBool: false,
                trabajadorBool: false,
                estacionBool: false,
                usuarioBool:false,
                abierta: true,
                cerrada: false,
                opcionSeleccionada:1,
                opcionSeleccionadaSesion:1,
                opcionSeleccionadaTrabajador:1,
                opcionSeleccionadaEstacion:1,
                opcionSeleccionadaUsuario:1,
                opcionSeleccionada2: 1,
                opcionSeleccionada3: 1,
                opcionSeleccionada4: 1,
                opcionSeleccionada5: 1,
                opcionSeleccionada9: 1,
                fecha_oc:'',
                fecha_entrega:'',               
                //OPCION 2 OT
                    searchOt: '',
                    resultsOt: '',
                    isOpenOt: false,
                //OPCION 6 OT
                    searchCliente: '',
                    resultsCliente: '',
                    isOpenCliente: false,
                //OPCION 7 OT
                    searchProducto: '',
                    resultsProducto: '',
                    isOpenProducto: false,
                //OPCION 8 OT
                    searchResponsable: '',
                    resultsResponsable: '',
                    isOpenResponsable: false,
                //OPCION 9 OT
                    searchTipo: '',
                    value: [],
                    options: [
                        { name: 'Vue.js', language: 'JavaScript' },
                        { name: 'Adonis', language: 'JavaScript' },
                        { name: 'Rails', language: 'Ruby' },
                        { name: 'Sinatra', language: 'Ruby' },
                        { name: 'Laravel', language: 'PHP' },
                        { name: 'Phoenix', language: 'Elixir' }
                    ],
                
                //CON SESION
                    opcionSeleccionadaSesion2: 1,
                    opcionSeleccionadaSesion3: 1,
                    fecha_sesion: '',
                    //OPCION 2 SESION
                        searchSesionOt: '',
                        resultsSesionOt: '',
                        isOpenSesionOt: false,
                    //OPCION 4 SESION
                        searchSesionArea: '',
                        resultsSesionArea: '',                       
                        isOpenSesionArea: false,
                    //OPCION 5 SESION
                        searchSesionEstacion: '',
                        resultsSesionEstacion: '',                       
                        isOpenSesionEstacion: false,   
                    //OPCION 6 SESION
                        searchSesionNave: '',
                        resultsSesionNave: '',                       
                        isOpenSesionNave: false,
                    //OPCION 8 SESION
                        searchSesionCodigo: '',
                        resultsSesionCodigo: '',                       
                        isOpenSesionCodigo: false,
                //CON TRABAJADOR
                    //OPCION 2 SESION
                        searchTrabajadorArea: '',
                        resultsTrabajadorArea: '',
                        isOpenTrabajadorArea: false,
                //CON ESTACION
                //CON USUARIO
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            volverMenu(){
                console.log("atras de reporte")
                this.$emit('botonAtrasReporte')
            },
            nameWithLang ({nombre_tipo}) {
                return `${nombre_tipo}`
                },
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
            botonSobreSesiones(){
                if(this.sesionBool== true){
                    this.sesionBool= false;
                    return 1;
                }
                else{
                    console.log("dfsa");
                    this.sesionBool= true;
                    return 1;
                }
            },
            botonSobreTrabajadores(){
                if(this.trabajadorBool== true){
                    this.trabajadorBool= false;
                    return 1;
                }
                else{
                    console.log("dfsa");
                    this.trabajadorBool= true;
                    return 1;
                }
            },
            botonSobreEstaciones(){
                if(this.estacionBool== true){
                    this.estacionBool= false;
                    return 1;
                }
                else{
                    console.log("dfsa");
                    this.estacionBool= true;
                    return 1;
                }
            },
            botonSobreUsuarios(){
                if(this.usuarioBool== true){
                    this.usuarioBool= false;
                    return 1;
                }
                else{
                    console.log("dfsa");
                    this.usuarioBool= true;
                    return 1;
                }
            },
            clickExportar(){
                var aux1 = null;
                var aux2 = null;
                if(this.opcionSeleccionada==1){aux1=null;aux2=null;}
                if(this.opcionSeleccionada==2){aux1=this.opcionSeleccionada2;aux2=this.searchOt;}
                if(this.opcionSeleccionada==3){aux1=this.opcionSeleccionada3;aux2=this.fecha_oc;}
                if(this.opcionSeleccionada==4){aux1=this.opcionSeleccionada4;aux2=this.fecha_entrega;}
                if(this.opcionSeleccionada==5){aux1=null;aux2= this.opcionSeleccionada5;}
                if(this.opcionSeleccionada==6){aux1=null;aux2=this.searchCliente;}
                if(this.opcionSeleccionada==7){aux1=null;aux2=this.searchProducto;}
                if(this.opcionSeleccionada==8){aux1=null;aux2=this.searchResponsable;}
                if(this.opcionSeleccionada==9){aux1=null;aux2=this.searchTipo;}
                var params={
                    opcion: this.opcionSeleccionada,
                    operacion: aux1,
                    cuerpo: aux2,
                    abierta: this.abierta,
                    cerrada: this.cerrada
                };
                console.log(params);
                console.log("searchres");
                console.log(this.searchTipo);            
                    axios({
                        url: 'http://localhost:8000/exportarExcel',
                        method: 'POST',
                        data: params,
                        responseType: 'blob', // important
                        }).then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'file.xlsx');
                        document.body.appendChild(link);
                        link.click();
                    });
            },
            clickExportarSesion(){
                var aux1 = null;
                var aux2 = null;
                if(this.opcionSeleccionadaSesion==1){aux1=null;aux2=null;}
                if(this.opcionSeleccionadaSesion==2){aux1=this.opcionSeleccionadaSesion2;aux2=this.searchSesionOt;}
                if(this.opcionSeleccionadaSesion==3){aux1=this.opcionSeleccionadaSesion3;aux2=this.fecha_sesion;}
                if(this.opcionSeleccionadaSesion==4){aux1=null;aux2=this.searchSesionArea;}
                if(this.opcionSeleccionadaSesion==5){aux1=null;aux2=this.searchSesionEstacion;}
                if(this.opcionSeleccionadaSesion==6){aux1=null;aux2=this.searchSesionNave;}
                if(this.opcionSeleccionadaSesion==7){aux1=null;aux2=null;}
                if(this.opcionSeleccionadaSesion==8){aux1=null;aux2=this.searchSesionCodigo;}
                var params={
                        opcion: this.opcionSeleccionadaSesion,
                        operacion: aux1,
                        cuerpo: aux2
                    };
                console.log("soy de sesion")
                console.log(params);
                axios({
                    url: 'http://localhost:8000/exportarExcelSesion',
                    method: 'POST',
                    data: params,
                    responseType: 'blob', // important
                    }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'fileSesion.xlsx');
                    document.body.appendChild(link);
                    link.click();
                });   
            },
            clickExportarTrabajador(){
                var aux1 = null;
                var aux2 = null;
                if(this.opcionSeleccionadaTrabajador==1){aux1=null;aux2=null;}
                if(this.opcionSeleccionadaTrabajador==2){aux1=null;aux2=this.searchTrabajadorArea;}
                var params={
                        opcion: this.opcionSeleccionadaTrabajador,
                        operacion: aux1,
                        cuerpo: aux2
                    };
                console.log("soy de sesion")
                console.log(params);
                axios({
                    url: 'http://localhost:8000/exportarExcelTrabajador',
                    method: 'POST',
                    data: params,
                    responseType: 'blob', // important
                    }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'fileSesion.xlsx');
                    document.body.appendChild(link);
                    link.click();
                });   
            },
            clickExportarEstacion(){
                var aux1 = null;
                var aux2 = null;
                if(this.opcionSeleccionadaEstacion==1){aux1=null;aux2=null;}
                //if(this.opcionSeleccionadaUsuario==2){aux1=null;aux2=this.searchTrabajadorArea;}
                var params={
                        opcion: this.opcionSeleccionadaEstacion,
                        operacion: aux1,
                        cuerpo: aux2
                    };
                console.log("soy de sesion")
                console.log(params);
                axios({
                    url: 'http://localhost:8000/exportarExcelEstacion',
                    method: 'POST',
                    data: params,
                    responseType: 'blob', // important
                    }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'fileSesion.xlsx');
                    document.body.appendChild(link);
                    link.click();
                });   
            },
            clickExportarUsuario(){
                var aux1 = null;
                var aux2 = null;
                if(this.opcionSeleccionadaUsuario==1){aux1=null;aux2=null;}
                //if(this.opcionSeleccionadaUsuario==2){aux1=null;aux2=this.searchTrabajadorArea;}
                var params={
                        opcion: this.opcionSeleccionadaUsuario,
                        operacion: aux1,
                        cuerpo: aux2
                    };
                console.log("soy de sesion")
                console.log(params);
                axios({
                    url: 'http://localhost:8000/exportarExcelUsuario',
                    method: 'POST',
                    data: params,
                    responseType: 'blob', // important
                    }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'fileSesion.xlsx');
                    document.body.appendChild(link);
                    link.click();
                });   
            },
            //OT
                //OPCION 2
                    onChangueOt(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenOt=true;
                        this.filterResultsOt();
                    },
                    filterResultsOt(){
                        this.resultsOt = this.ots.filter(item => item.id.toString().toLowerCase().indexOf(this.searchOt.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultOt(result){
                        console.log("result");
                        console.log(result);
                        this.searchOt = result.id;
                        this.isOpenOt = false;
                    },
                    loseFocusOt(result){
                        this.isOpenOt = false;
                    },
                //OPCION 6
                    onChangueCliente(){
                        this.isOpenCliente=true;
                        this.filterResultsCliente();
                    },
                    filterResultsCliente(){
                        this.resultsCliente = this.clientes.filter(item => item.nombre_cliente.toLowerCase().indexOf(this.searchCliente.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultCliente(result){
                        this.searchCliente = result.nombre_cliente;
                        this.isOpenCliente = false;
                    },
                    loseFocusCliente(result){
                        this.isOpenCliente = false;
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
                        this.resultsResponsable = this.responsables.filter(item => item.nombre_usuario.toLowerCase().indexOf(this.searchResponsable.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultResponsable(result){
                        this.searchResponsable = result.nombre_usuario;
                        this.isOpenResponsable = false;
                    },
                    loseFocusResponsable(){
                        this.isOpenResponsable = false;
                    },
            //SESION
                //OPCION 2
                    onChangueSesionOt(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenSesionOt=true;
                        this.filterResultsSesionOt();
                    },
                    filterResultsSesionOt(){
                        this.resultsSesionOt = this.ots.filter(item => item.id.toString().toLowerCase().indexOf(this.searchSesionOt.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultSesionOt(result){
                        console.log("result");
                        console.log(result);
                        this.searchSesionOt = result.id;
                        this.isOpenSesionOt = false;
                    },
                    loseFocusSesionOt(result){
                        this.isOpenSesionOt = false;
                    },
                //OPCION 4
                    onChangueSesionArea(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenSesionArea=true;
                        this.filterResultsSesionArea();
                    },
                    filterResultsSesionArea(){
                        this.resultsSesionArea = this.areas.filter(item => item.nombre_area.toString().toLowerCase().indexOf(this.searchSesionArea.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultSesionArea(result){
                        console.log("result");
                        console.log(result);
                        this.searchSesionArea = result.nombre_area;
                        this.isOpenSesionArea = false;
                    },
                    loseFocusSesionArea(result){
                        this.isOpenSesionArea = false;
                    },
                //OPCION 5
                    onChangueSesionEstacion(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenSesionEstacion=true;
                        this.filterResultsSesionEstacion();
                    },
                    filterResultsSesionEstacion(){
                        this.resultsSesionEstacion = this.estaciones.filter(item => item.codigo.toString().toLowerCase().indexOf(this.searchSesionEstacion.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultSesionEstacion(result){
                        console.log("result");
                        console.log(result);
                        this.searchSesionEstacion = result.codigo;
                        this.isOpenSesionEstacion = false;
                    },
                    loseFocusSesionEstacion(result){
                        this.isOpenSesionEstacion = false;
                    },
                //OPCION 6
                    onChangueSesionNave(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenSesionNave=true;
                        this.filterResultsSesionNave();
                    },
                    filterResultsSesionNave(){
                        this.resultsSesionNave = this.naves.filter(item => item.nombre_nave.toString().toLowerCase().indexOf(this.searchSesionNave.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultSesionNave(result){
                        console.log("result");
                        console.log(result);
                        this.searchSesionNave = result.nombre_nave;
                        this.isOpenSesionNave = false;
                    },
                    loseFocusSesionNave(result){
                        this.isOpenSesionNave = false;
                    },
                //OPCION 8
                    onChangueSesionCodigo(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenSesionCodigo=true;
                        this.filterResultsSesionCodigo();
                    },
                    filterResultsSesionCodigo(){
                        this.resultsSesionCodigo = this.productos.filter(item => item.codigo_siom.toString().toLowerCase().indexOf(this.searchSesionCodigo.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultSesionCodigo(result){
                        console.log("result");
                        console.log(result);
                        this.searchSesionCodigo = result.codigo_siom;
                        this.isOpenSesionCodigo = false;
                    },
                    loseFocusSesionCodigo(result){
                        this.isOpenSesionCodigo = false;
                    },
            //TRABAJADOR
                //OPCION 2
                    onChangueTrabajadorArea(){
                        console.log("ots:");
                        console.log(this.ots);
                        this.isOpenTrabajadorArea=true;
                        this.filterResultsTrabajadorArea();
                    },
                    filterResultsTrabajadorArea(){
                        this.resultsTrabajadorArea = this.areas.filter(item => item.nombre_area.toString().toLowerCase().indexOf(this.searchTrabajadorArea.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultTrabajadorArea(result){
                        console.log("result");
                        console.log(result);
                        this.searchTrabajadorArea = result.nombre_area;
                        this.isOpenTrabajadorArea = false;
                    },
                    loseFocusTrabajadorArea(result){
                        this.isOpenTrabajadorArea = false;
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