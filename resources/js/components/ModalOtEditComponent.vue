<template>
<div>
    <!-- <div v-if="crearMaterialBool"> CREATE MATERIAL
                    <modal-material-create-component
                    :key="creacionN"
                    :tipoMaterial="tipoMaterial"
                    :clientes="clientes"
                    @botonGuardarCreacionMaterial="guardarCreacionMaterial">
                    </modal-material-create-component> 
    </div> -->
    <div  class="modal " id="modalEditOt" tabindex="-1" role="dialog" aria-labelledby="modalEditOtLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditOtLabel">Edición de OT {{otSeleccionada.id}}  </h5>
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
                                        <label class= "lavelFont font-weight-bold">Canal de Venta:</label>
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
                                        <select required v-model="canal"  class="form-control">
                                            <option disabled selected >Canales de Venta</option>
                                            <option v-for="(canal,index) in canales" v-bind:key="index" v-bind:value="canal">
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
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="codigoCliente" @change="cambiarCodigo(codigoCliente)" class="form-control">
                                                <option :value="-1"  selected >Nuevo</option>
                                                <option v-for="(codigo,index) in codigosCliente" v-bind:key="index" v-bind:value="index">
                                                    {{ codigo }}
                                                </option>
                                        </select>
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
                                        <button type="button" @click="crearMaterial()" data-target="#modalCreateMaterial" data-toggle="modal" class="btn btn-lg btn-block btn-secondary">Crear Material</button>
                                    </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        * {{seleccionados}}
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
                                                        <select required v-model="producto[3]"  class="form-control">
                                                            <option disabled selected >Categorías</option>
                                                            <option v-for="(categoria,index) in categorias" v-bind:key="index" v-bind:value="categoria">
                                                                {{ categoria.nombre_categoria }}
                                                            </option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha de Entrega OC:</label>
                                                        <input required type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[4]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha real de Entrega:</label> <!--5 -->
                                                        <input required type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[5]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Fecha de Despacho:</label> <!--6 -->
                                                        <input required type="date"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[6]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Guia de Despacho:</label> <!--7 -->
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[7]">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label class= "lavelFont2 font-weight-bold">Factura:</label> <!--8 -->
                                                        <input required type="text"  class="form-control input-sm" aria-describedby="emailHelp" v-model="producto[8]">
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
                            <!--
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">País de Ot:</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                     <select required v-model="otPeru" class="form-control">
                                            <option disabled selected >Países</option>
                                            <option  v-bind:value="false">Chile</option>
                                            <option  v-bind:value="true">Perú</option>
                                        </select>        
                                    </div>
                                    <div class="col-md-9">
                                        
                                        <div class="col-md-1"></div>
                                        <div class="color4 row">   
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <input class="form-check-input" :value="true" :unchecked-value="false" v-model="abierta" id="abierta" type="checkbox">
                                                    <p>{{" "}}</p>
                                                    <label style="font-size:18px" for = "abierta">{{'   Abierta'}}</label> 
                                                </div>
                                            </div>  
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <input class="form-check-input" :value="true" :unchecked-value="false" v-model="recepcionada" id="recepcionada" type="checkbox">
                                                    <p>{{" "}}</p>
                                                    <label style="font-size:18px" for = "recepcionada">{{'   Recepcionada'}}</label> 
                                                </div>
                                            </div>  
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <input class="form-check-input" :value="true" :unchecked-value="false" v-model="despachada" id="despachada" type="checkbox">
                                                    <p>{{" "}}</p>
                                                    <label style="font-size:18px" for = "despachada">{{'   Despachada'}}</label> 
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Orden de Compra:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Número de Cotización</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Guía de Despacho</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="orden">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="numero">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="guia"> 
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Factura:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Fecha de Recepción</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Fecha de Entrega:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="factura"> 
                                    </div>
                                    <div class="col-md-4">
                                        <input required type="date"  class="form-control" aria-describedby="emailHelp" v-model="recepcion"> 
                                    </div>
                                    <div class="col-md-4">
                                        <input required type="date"  class="form-control" aria-describedby="emailHelp" v-model="fecha"> 
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Cliente:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Categoría:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Tipo</label>
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
                                        <select required v-model="categoria"  class="form-control">
                                            <option disabled selected >Categorías</option>
                                            <option v-for="(categoria,index) in categorias" v-bind:key="index" v-bind:value="categoria">
                                                {{ categoria.nombre_categoria }}
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
                                            <option v-for="(usuario,index) in usuarios" v-bind:key="index" v-bind:value="usuario">
                                                {{ usuario.nombre_usuario }}
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
                                        <select required v-model="canal"  class="form-control">
                                            <option disabled selected >Canales de Venta</option>
                                            <option v-for="(canal,index) in canales" v-bind:key="index" v-bind:value="canal">
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
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="codigoCliente" @change="cambiarCodigo(codigoCliente)" class="form-control">
                                                <option :value="-1"  selected >Nuevo</option>
                                                <option v-for="(codigo,index) in codigosCliente" v-bind:key="index" v-bind:value="index">
                                                    {{ codigo }}
                                                </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="producto"  class="form-control">
                                                <option disabled selected >Material:</option>
                                                <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                                    {{ productos[index].nombre }}
                                                </option>
                                        </select>
                                    </div>                                         
                                    <div class="col-md-1">
                                       
                                        <button type="button"  v-on:click= "agregarProducto()" :disabled="1==3" class="btn btn-success">+</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" @click="crearMaterial()" data-target="#modalCreateMaterial" data-toggle="modal" class="btn btn-lg btn-block btn-secondary">Crear Material</button>
                                    </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        <div class="row">
                                            <div class="col-sm-4"><label class= "lavelFont2 font-weight-bold">Descripción:</label></div>
                                            <div class="col-sm-2"><label class= "lavelFont2 font-weight-bold">Código de Cliente:</label></div>
                                            <div class="col-sm-1"><label class= "lavelFont2 font-weight-bold">Cantidad:</label></div>
                                            <div class="col-sm-2"><label class= "lavelFont2 font-weight-bold">Código Siom:</label></div>
                                            <div class="col-sm-2"><label class= "lavelFont2 font-weight-bold">Número de plano:</label></div>
                                            <div class="col-sm-1"><label class= "lavelFont2 font-weight-bold">Quitar:</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="containerf color3">
                                            <br>
                                            <div v-for="(producto,index) in seleccionados" v-bind:key="index">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <p>* {{producto[0].nombre_producto}} </p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input required type="text"  class="form-control" aria-describedby="emailHelp" v-model="producto[2]"> 
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <input required type="number"  @mouseenter="cambiarCliente()" class="form-control" aria-describedby="emailHelp" v-model="producto[1]"> 
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input required type="text"  class="form-control" aria-describedby="emailHelp" v-model="producto[0].codigo_siom"> 
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input required type="text"  class="form-control" aria-describedby="emailHelp" v-model="producto[0].numero_plano"> 
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" :value="index"  v-on:click= "quitarProducto(index)" class="btn btn-danger">-</button>
                                                    </div>
                                                </div>
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
                            </div>-->
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
        props: ['viejos','seleccionados','centros','canales','usuarios','tipos','categorias','clientes','productos','otSeleccionada'],
        data(){
            return {
                otPeru: false,
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
                tipoMaterial:"",
                creacionN:0,
                abierta:this.otSeleccionada.abierta,
                recepcionada:this.otSeleccionada.recepcionada,
                despachada: this.otSeleccionada.despachada,
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
           /* for(var i=0;i<this.productos.length;i++){
                if(this.productos[i][9]==null){
                    this.productos[i][9] = 1; 
                }
                if(this.productos[i][10]!=1 && this.productos[i][10]!=0){
                    this.productos[i][10] = 0; 
                }
                if(this.productos[i][11]!=1 && this.productos[i][11]!=0){
                    this.productos[i][11] = 0; 
                }
            }   */
        },
        methods:{
            guardarCreacionMaterial(){

                this.creacionN +=1;
                this.cambiarCliente();
                this.$emit('botonGuardarCreacionMaterial')
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
            cambiarCodigo(index){
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
            }
        }
    }
</script>