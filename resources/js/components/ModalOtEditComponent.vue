<template>
<div>
     <div v-if="crearMaterialBool"> 
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
    <div  class="modal " id="modalEditOt" tabindex="-1" role="dialog" aria-labelledby="modalEditOtLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditOtLabel">Edición de OT {{otSeleccionada.id}}  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div @click="isOpenCodigo=false" class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Orden de Compra:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Número de Cotización</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Canal de Venta:</label>   
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="orden">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="numero">
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="canal"  class="form-control">
                                            <option disabled selected >Canales de Venta</option>
                                            <option v-for="(canal,index) in canales" v-bind:key="index" v-bind:value="canal">
                                                {{ canal.nombre_canal }}
                                            </option>
                                        </select>   
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
                                            <option v-for="(cliente,index) in clientes" v-bind:key="index" v-bind:value="cliente">
                                                {{ cliente.nombre_cliente }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="tipo"  class="form-control">
                                            <option disabled selected >Tipos de OT</option>
                                            <option v-for="(tipo,index) in tipos" v-bind:key="index" v-bind:value="tipo">
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
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="responsable"  class="form-control">
                                            <option disabled selected >Responsables</option>
                                            <option v-for="(responsable,index) in usuarios" v-bind:key="index" v-bind:value="responsable">
                                                {{ responsable.nombre_usuario }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="centro"  class="form-control">
                                            <option disabled selected >Centros de Costo</option>
                                            <option v-for="(centro,index) in centros" v-bind:key="index" v-bind:value="centro">
                                                {{ centro.nombre_centro }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        
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
                                            <ul v-show="isOpenCodigo" class="autocomplete-results">
                                                <li  @click="setResultCodigo(result,i)" v-for="(result,i) in resultsCodigo" :key="i" class="autocomplete-result">{{result}}</li>
                                            </ul>   
                                        <!--
                                        <select required v-model="codigoCliente" @change="cambiarCodigo(codigoCliente)" class="form-control">
                                                <option :value="-1"  selected >Nuevo</option>
                                                <option v-for="(codigo,index) in codigosCliente" v-bind:key="index" v-bind:value="index">
                                                    {{ codigo }}
                                                </option>
                                        </select> -->
                                    </div>
                                    <div class="col-md-4">
                                        <select @change="seleccionProducto" required v-model="producto"  class="form-control">
                                                <option disabled selected >Material:</option>
                                                <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                                    {{ productos[index].nombre_producto }}
                                                </option>
                                        </select>
                                    </div>                                         
                                    <div class="col-md-1">
                                       
                                        <button type="button"  v-on:click= "agregarProducto()" :disabled="productoSeleccionadoBool" class="btn btn-success">+</button>
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
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <input class="form-check-input" :value="true" :unchecked-value="false" v-model="producto[9]" :id="'abierta'+index" type="checkbox">
                                                            <p>{{" "}}</p>
                                                            <label style="font-size:18px" :for ="'abierta'+index">{{'   Abierta'}}</label> 
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <input class="form-check-input" :value="true" :unchecked-value="false" v-model="producto[10]" :id="'recepcionada'+index" type="checkbox">
                                                            <p>{{" "}}</p>
                                                            <label style="font-size:18px" :for ="'recepcionada'+index">{{'   Recepcionada'}}</label> 
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <input class="form-check-input" :value="true" :unchecked-value="false" v-model="producto[11]" :id="'despachada'+index" type="checkbox">
                                                            <p>{{" "}}</p>
                                                            <label style="font-size:18px" :for="'despachada'+index">{{'   Despachada'}}</label> 
                                                        </div>
                                                    </div>   
                                                    <div class="col-sm-1">
                                                        <button type="button" :value="index"  v-on:click= "quitarProducto(index)" class="btn btn-outline-danger btn-sm">Quitar</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Código de Cliente:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[2]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Cantidad:</label>
                                                        <input required type="number" min="1"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[1]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Código Siom:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[0].codigo_siom">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Número de Plano:</label>
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[0].numero_plano">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Categoría:</label>
                                                        <select required v-model="producto[0].categoria_id"  class="form-control">
                                                            <option disabled selected >Categorías</option>
                                                            <option v-for="(categoria,index) in categorias" v-bind:key="index" v-bind:value="categoria.id">
                                                                {{ categoria.nombre_categoria }}
                                                            </option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha de Entrega OC:</label>
                                                        <input  type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[4]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha real de Entrega:</label> <!--5 -->
                                                        <input  type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[5]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha de Despacho:</label> <!--6 -->
                                                        <input  type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[6]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Guia de Despacho:</label> <!--7 -->
                                                        <input  type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[7]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Factura:</label> <!--8 -->
                                                        <input  type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[8]">
                                                        <br>
                                                    </div>
                                                  <!--  <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Estado:</label> 5 
                                                        <input required type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[8]">
                                                    </div>-->
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
                        <button type="button" @click="cerrar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="guardarCambios" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: ['peru','viejos','seleccionados','centros','canales','usuarios','tipos','categorias','clientes','productos','otSeleccionada'],
        data(){
            return {
                otPeru: this.peru,
                orden: this.otSeleccionada.orden_compra,
                numero: this.otSeleccionada.numero_cotizacion,
                guia: this.otSeleccionada.guia_despacho,
                factura: this.otSeleccionada.factura,
                fecha: this.otSeleccionada.fecha_entrega_oc,
                recepcion: this.otSeleccionada.fecha_recepcion,
                tipo: this.otSeleccionada.ot_tipo,
                categoria: this.otSeleccionada.categoria_ot,
                cliente: this.otSeleccionada.cliente,
                canal:this.otSeleccionada.canal_venta,
                centro: this.otSeleccionada.centro_costo,
                responsable: this.otSeleccionada.usuario,
                producto: this.otSeleccionada.productos,
                observacion: this.otSeleccionada.observacion,
                codigoCliente:"",
                codigosCliente:[],
                cantidad: "",
                aux:[],
                crearMaterialBool:false,
                crearClienteBool:false,
                tipoMaterial:"",
                creacionN:0,
                creacionNC:0,
                abierta:"",
                recepcionada:"",
                despachada:"",
                searchCodigo: '',
                resultsCodigo: '',
                isOpenCodigo: false,
                codigoSeleccionadoBool:false,
                productoSeleccionadoBool: true
            }
        },
        mounted() { 
            console.log('Component mounted.')
            axios
                    .get('http://localhost:8000/obtenerCodigosCliente/'+this.cliente.id) //this.clientes[this.cliente].id)
                    .then(response => { 
                        this.aux=response.data;
                        console.log(this.aux)
                        this.codigosCliente=[];
                        for(var j=0;j<this.aux.length;j++){
                            this.codigosCliente.push(this.aux[j].codigo_cliente);
                        }
                    })
        },
        methods:{
            seleccionProducto(){
                this.productoSeleccionadoBool=false;
            },
            guardarCambios(){
                if(this.cliente==null || this.cliente==''){
                    alert('Debe ingresar un Cliente');
                    return false;
                }
                if(this.tipo==null || this.tipo=='' ){
                    alert('Debe ingresar un Tipo de OT');
                    return false;
                }
                if(this.recepcion==null || this.recepcion==''){
                    alert('Debe ingresar una Fecha de Recepción');
                    return false;
                }
                if(this.responsable==null || this.responsable==''){
                    console.log(this.responsable);
                    alert('Debe ingresar un Responsable');
                    return false;
                }
                if(this.centro==null || this.centro==''){
                    alert('Debe ingresar un Centro de Costos');
                    return false;
                }
                if(this.canal==null || this.canal==''){
                    alert('Debe ingresar un Canal de Ventas');
                    return false;
                }
                for(var i=0;i<this.seleccionados.length;i++){
                    this.seleccionados[i][12] = null;
                    if(this.seleccionados[i][9]==undefined){
                        this.seleccionados[i][9] = true; 
                    }console.log("this.productos[i][10]");console.log(this.seleccionados[i][10]);
                    if(this.seleccionados[i][10]==undefined){
                        console.log("entre");
                        this.seleccionados[i][10] = false; 
                    }
                    if(this.seleccionados[i][11]==undefined){
                        this.seleccionados[i][11] = false; 
                    }
                    for(var k=0; k< this.seleccionados.length;k++){
                    if(this.seleccionados[k][2]==undefined){
                        alert("Debe ingresar el Código Cliente del Producto")
                        return false;
                    }
                    if(this.seleccionados[k][1]==undefined){
                        alert("Debe ingresar la Cantidad de Unidades del Producto")
                        return false;
                    }
                    if(this.seleccionados[k][0].codigo_siom==""){
                        alert("Debe ingresar el Código Siom del Producto")
                        return false;
                    }
                    if(this.seleccionados[k][0].numero_plano==""){
                        alert("Debe ingresar el Número de Plano del Producto")
                        return false;
                    }
                    if(this.seleccionados[k][0].categoria_id==""){
                        alert("Debe ingresar la Categoría del Producto")
                        return false;
                    }
                   /* console.log("categoria = ");
                    console.log(this.seleccionados[k][3]);
                    if(this.seleccionados[k][3]== undefined){
                        alert("Debe ingresar la Categoría del Producto")
                        return false;
                    }*/
                    if(this.seleccionados[k][4]== undefined){
                        alert("Debe ingresar la Fecha de Entrega del Producto")
                        return false;
                    }
                }
                }
                console.log("en guardar:")
                console.log(this.responsable);
                var params={
                    otPeru: this.otPeru,
                    orden: this.orden,
                    numero: this.numero,
                    guia: this.guia,
                    factura: this.factura,
                    fecha:  this.fecha,
                    recepcion: this.recepcion,
                    tipo: this.tipo,
                    categoria: this.categoria,
                    cliente:this.cliente,
                    canal: this.canal,
                    centro: this.centro,
                    responsable: this.responsable,
                    seleccionados: this.seleccionados,
                    observacion: this.observacion,
                    abierta: this.abierta,
                    recepcionada: this.recepcionada,
                    despachada: this.despachada,
                    viejos: this.viejos
                }
                console.log(params);
                axios
                    .put('http://localhost:8000/ot/'+this.otSeleccionada.id , params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalEditOt').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarEdicionOt');
                        alert("OT actualizada exitosamente");
                    })
            },
            cerrar(){
               // this.$emit('botonGuardarEdicionOt');   
            },
             onChangueCodigo(){
                 console.log("this.searchCodigo")
                console.log(this.searchCodigo);
                if(this.searchCodigo!=''){
                    this.codigoSeleccionadoBool = true;
                    console.log("lo bloquie");
                }
                else{
                    this.codigoSeleccionadoBool = false
                }
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
                        if(this.searchCodigo!=''){
                            this.codigoSeleccionadoBool = true;
                            console.log("lo bloquie");
                        }
                        else{
                            this.codigoSeleccionadoBool = false
                        }
                        this.productoSeleccionadoBool=false;
                        this.cambiarCodigo(result,i);
                    },
            guardarCreacionCliente(){
                this.creacionNC +=1;
                axios
                .get('http://localhost:8000/cliente') //solicitar tipo material
                            .then(response => {
                                this.clientes = response.data;
                                })
            },
            guardarCreacionMaterial(){

                this.creacionN +=1;
                this.cambiarCliente();
                this.$emit('botonGuardarCreacionMaterial')
            },
            crearCliente(){
                $('#modalEditOt').modal('hide');
                $('.modal-backdrop').hide();
                console.log("sdfsd");
                this.crearClienteBool = true;
            },
            crearMaterial(){
                $('#modalEditOt').modal('hide');
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
                    .get('http://localhost:8000/obtenerCodigosCliente/'+this.cliente.id) //this.clientes[this.cliente].id)
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
                var indi = -1;
                //primer debo encontrar el indice del codigo cliente
                for(var j=0; j< this.aux.length;j++){
                    if(this.aux[j].codigo_cliente==this.codigoCliente){
                        indi = j;
                    }
                }
                console.log(this.codigoCliente);
                if(this.codigoCliente!= -1){
                    for(var i =0;i<this.productos.length;i++){
                        console.log("i = ");
                        console.log(i);
                        if(this.aux[indi].producto_id == this.productos[i].id){
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
                for(var i=0;i<this.seleccionados.length;i++){
                    if(this.seleccionados[i][0]==this.productos[this.producto]){
                        return false;
                    }
                }
                //trael el codigo de cliente
                var params ={
                    producto: this.productos[this.producto].id,
                    cliente: this.cliente.id
                }
                axios
                    .post('http://localhost:8000/obtenerClienteCodigo/',params)
                    .then(response => { 
                        console.log("respuesta:");
                        console.log(response.data);
                        if(response.data != 0){
                            this.searchCodigo = response.data
                        }  
                        var aux = [];
                        aux.push(this.productos[this.producto]);
                        aux.push(this.cantidad);
                        aux.push(this.searchCodigo);
                        this.seleccionados.push(aux);     
                    })   
            },
            quitarProducto(index){
                this.seleccionados.splice(index,1);
            },
            
        }
    }
</script>