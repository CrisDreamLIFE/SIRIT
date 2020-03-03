<template>
<div>
    <div v-if="crearMaterialBool"> <!-- CREATE MATERIAL -->
                    <modal-material-create-component
                    :key="creacionN"
                    :tipoMaterial="tipoMaterial"
                    :clientes="clientes"
                    @botonGuardarCreacionMaterial="guardarCreacionMaterial">
                    </modal-material-create-component> 
    </div>
    <div v-if="crearClienteBool"> <!-- CREATE CLIENTE -->
                    <modal-cliente-create-component
                    :key="creacionNC"
                    @botonGuardarCreacionCliente="guardarCreacionCliente">
                    </modal-cliente-create-component> 
    </div>
    <div  class="modal " id="modalCreateOt" tabindex="-1" role="dialog" aria-labelledby="modalCreateOtLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateOtLabel">Creacion de nueva OT </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">País de Ot:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Orden de Compra:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Número de Cotización</label>
                                    </div>
                                    <div class="col-md-4">
                                     <select required v-model="otPeru" class="form-control">
                                            <option disabled selected >Países</option>
                                            <option  v-bind:value="false">Chile</option>
                                            <option  v-bind:value="true">Perú</option>
                                        </select>     
                                    </div>  
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="orden">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="numero">
                                    </div>
                                </div>  
                                <br>     
                                <div class="row">               
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Cliente:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Tipo</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Fecha de Recepción</label>
                                    </div>          
                                    <div class="col-md-4">
                                        <select required v-model="cliente" @change="cambiarCliente" class="form-control">
                                            <option disabled selected >Clientes</option>
                                            <option v-for="(cliente,index) in clientes" v-bind:key="index" v-bind:value="index">
                                                {{ cliente.nombre_cliente }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="tipo"  class="form-control">
                                            <option disabled selected >Tipos de OT</option>
                                            <option v-for="(tipo,index) in tipos" v-bind:key="index" v-bind:value="index">
                                                {{ tipo.nombre_tipo }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input required type="date"  class="form-control" aria-describedby="emailHelp" v-model="recepcion"> 
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">     
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Responsable:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Centro de Costo:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Canal de Venta:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="responsable"  class="form-control">
                                            <option disabled selected >Responsables</option>
                                            <option v-for="(responsable,index) in usuarios" v-bind:key="index" v-bind:value="index">
                                                {{ responsable.nombre_usuario }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="centro"  class="form-control">
                                            <option disabled selected >Centros de Costo</option>
                                            <option v-for="(centro,index) in centros" v-bind:key="index" v-bind:value="index">
                                                {{ centro.nombre_centro }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="canal"  class="form-control">
                                            <option disabled selected >Canales de Venta</option>
                                            <option v-for="(canal,index) in canales" v-bind:key="index" v-bind:value="index">
                                                {{ canal.nombre_canal }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Código de Cliente:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Producto:</label>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <button type="button" @click="crearCliente()" data-target="#modalCreateCliente" data-toggle="modal" class="btn btn-sm btn-block btn-secondary">CREAR CLIENTE</button>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="Sesion2-1" class="form-control" type="text" v-model="searchCodigo" @input="onChangueCodigo"/>
                                        <ul @mouseleave="isOpenCodigo=false" v-show="isOpenCodigo" class="autocomplete-results">
                                            <li  @click="setResultCodigo(result,i)" v-for="(result,i) in resultsCodigo" :key="i" class="autocomplete-result">{{result}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="producto"  class="form-control">
                                                <option disabled selected >Material:</option>
                                                <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                                    {{ productos[index].nombre_producto }}
                                                </option>
                                        </select>
                                    </div>                                         
                                    <div class="col-md-1">
                                       
                                        <button type="button"  v-on:click= "agregarProducto()" :disabled="1==3" class="btn btn-success">+</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" @click="crearMaterial()" data-target="#modalCreateMaterial" data-toggle="modal" class="btn btn-sm btn-block btn-secondary">CREAR MATERIAL</button>
                                    </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        <div v-for="(producto,index) in seleccionados" v-bind:key="index">
                                            <div class="container color3">
                                                <div class="row">
                                                    <br>
                                                    <div class="col-sm-5">
                                                        <b style="padding-top:10px;font-size: 15px;">&nbsp; &nbsp;{{producto[0].nombre_producto}}</b>
                                                    </div>
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-2"></div>   
                                                    <div class="col-sm-1">
                                                        <button type="button" :value="index"  v-on:click= "quitarProducto(index)" class="btn btn-outline-danger btn-sm">Quitar</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Código de Cliente:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[2]">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Cantidad:</label>
                                                        <input required type="number" min="1"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[1]">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Código Siom:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[0].codigo_siom">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Número de Plano:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[0].numero_plano">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Categoría:</label>
                                                        <select required v-model="producto[3]"  class="form-control">
                                                            <option disabled selected >Categorías</option>
                                                            <option v-for="(categoria,index) in categorias" v-bind:key="index" v-bind:value="categoria">
                                                                {{ categoria.nombre_categoria }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha de Entrega:</label>
                                                        <input required type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[4]">
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class= "lavelFont font-weight-bold">Observación:</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea  class="form-control" aria-describedby="emailHelp" v-model="observacion" rows="3"></textarea> 
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="guardarCambios" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['centros','canales','usuarios','tipos','categorias','clientes','productos'],
        data(){
            return {
                otPeru: false,
                orden: "",
                numero: "",
                guia:"",
                factura:"",
                fecha:"",
                recepcion:"",
                tipo:"",
                categoria:"",
                cliente:"",
                canal:"",
                centro:"",
                responsable:"",
                producto: "",
                seleccionados:[],
                observacion:"",
                codigoCliente:"",
                codigosCliente:[],
                cantidad: "",
                aux:[],
                categoriaEscogida:"",
                crearMaterialBool:false,
                crearClienteBool:false,
                tipoMaterial:"",
                creacionN:0,
                creacionNC:0,
                searchCodigo: '',
                resultsCodigo: '',
                isOpenCodigo: false,
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
             onChangueCodigo(){
                        this.isOpenCodigo=true;
                        this.filterResultsCodigo();
                    },
                    filterResultsCodigo(){
                        this.resultsCodigo = this.codigosCliente.filter(item => item.toLowerCase().indexOf(this.searchCodigo.toLowerCase())>-1);
                        //esta hay que cambiarla.
                    },
                    setResultCodigo(result,i){
                        console.log("result");
                        console.log(result);
                        this.searchCodigo = result;
                        this.isOpenCodigo = false;
                        this.codigoCliente = result;
                        this.cambiarCodigo(result,i);
                    },
            guardarCreacionMaterial(){

                this.creacionN +=1;
                this.cambiarCliente();
                this.$emit('botonGuardarCreacionMaterial')
            },
            guardarCreacionCliente(){
                this.creacionNC +=1;
                axios
                .get('http://localhost:8000/cliente') //solicitar tipo material
                            .then(response => {
                                this.clientes = response.data;
                                })
            },
            crearCliente(){
                $('#modalCreateOt').modal('hide');
                $('.modal-backdrop').hide();
                console.log("sdfsd");
                this.crearClienteBool = true;
            },
            crearMaterial(){
                $('#modalCreateOt').modal('hide');
                $('.modal-backdrop').hide();
                axios
                .get('http://localhost:8000/tipoMaterial') //solicitar tipo material
                            .then(response => {
                                this.tipoMaterial = response.data;
                                })
                this.crearMaterialBool = true;
            },
            cambiarCliente(){
                console.log("entre a cambiar cliente");
                axios
                    .get('http://localhost:8000/obtenerCodigosCliente/'+this.clientes[this.cliente].id)
                    .then(response => { 
                        this.aux=response.data;
                        console.log(this.aux)
                        this.codigosCliente=[];
                        for(var j=0;j<this.aux.length;j++){
                            this.codigosCliente.push(this.aux[j].codigo_cliente);
                        }
                    })   
            },
            cambiarCodigo(result,index){
                console.log(this.productos);
                console.log("valor index: " )
                console.log(index);
                console.log(this.aux);
                console.log(this.codigoCliente);
                if(this.codigoCliente!= -1){
                    for(var i =0;i<this.productos.length;i++){
                        console.log("i = ");
                        console.log(i);
                        if(this.aux[index].producto_id == this.productos[i].id){
                            console.log("lo pille");
                            this.producto = i;    
                            break;
                        }
                    }
                }
              //  this.producto=aux[index].
                /*
                axios
                    .get('http://localhost:8000/obtenerCodigosCliente/'+this.clientes[this.cliente].id)
                    .then(response => { 
                        this.codigosCliente=response.data.codigo_cliente;
                    }) */  
            },
            agregarProducto(){
                var aux = [];
                aux.push(this.productos[this.producto]);
                aux.push(this.cantidad);
                aux.push(this.codigosCliente[this.codigoCliente]);
                this.seleccionados.push(aux);
            },
            quitarProducto(index){
                this.seleccionados.splice(index,1);
            },
            guardarCambios(){
                var params={
                    otPeru: this.otPeru,
                    orden: this.orden,
                    numero: this.numero,
                    guia: this.guia,
                    factura: this.factura,
                    fecha:  this.fecha,
                    recepcion: this.recepcion,
                    tipo: this.tipos[this.tipo],
                    categoria: this.categoria,
                    cliente: this.clientes[this.cliente],
                    canal: this.canales[this.canal],
                    centro: this.centros[this.centro],
                    responsable: this.usuarios[this.responsable],
                    seleccionados: this.seleccionados,
                    observacion: this.observacion
                }
                console.log(params);
                axios
                    .post('http://localhost:8000/ot/', params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalCreateOt').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarCreacionOt');
                        alert("OT creada exitosamente");
                    })
            }
        }
    }
</script>