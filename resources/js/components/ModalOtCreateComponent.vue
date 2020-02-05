<template>
<div>
    <div  class="modal " id="modalCreateOt" tabindex="-1" role="dialog" aria-labelledby="modalCreateOtLabel" aria-hidden="true">
                <div class="modal-dialog-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateOtLabel">Creacion de nueva OT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">OT-Perú:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Orden de Compra:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Número de Cotización</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" :value="1" v-model="otPeru">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="orden">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="numero">
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        {{otPeru}}
                                        <label class= "lavelFont font-weight-bold">Guía de Despacho</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Factura:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class= "lavelFont font-weight-bold">Fecha de Entrega:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="guia"> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  class="form-control" aria-describedby="emailHelp" v-model="factura"> 
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
                                        <select required v-model="cliente"  class="form-control">
                                            <option disabled selected >Clientes</option>
                                            <option v-for="(cliente,index) in clientes" v-bind:key="index" v-bind:value="cliente.id">
                                                {{ cliente.nombre }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="categoria"  class="form-control">
                                            <option disabled selected >Categorías</option>
                                            <option v-for="(categoria,index) in categorias" v-bind:key="index" v-bind:value="categoria.id">
                                                {{ categoria.nombre }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="tipo"  class="form-control">
                                            <option disabled selected >Tipos de OT</option>
                                            <option v-for="(tipo,index) in tipos" v-bind:key="index" v-bind:value="tipo.id">
                                                {{ tipo.nombre }}
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
                                            <option v-for="(responsable,index) in usuarios" v-bind:key="index" v-bind:value="responsable.id">
                                                {{ responsable.nombre }}
                                            </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="centro"  class="form-control">
                                            <option disabled selected >Centros de Costo</option>
                                            <option v-for="(centro,index) in centros" v-bind:key="index" v-bind:value="centro.id">
                                                {{ centro.nombre }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="canal"  class="form-control">
                                            <option disabled selected >Canales de Venta</option>
                                            <option v-for="(canal,index) in canales" v-bind:key="index" v-bind:value="canal.id">
                                                {{ canal.nombre }}
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
                                    <div class="col-md-2">
                                        <label class= "lavelFont font-weight-bold">Cantidad:</label>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <select required v-model="codigoCliente"  class="form-control">
                                                <option disabled selected >Códigos de Cliente:</option>
                                                <option v-for="(codigo,index) in codigosCliente" v-bind:key="index" v-bind:value="index">
                                                    {{ codigo }}
                                                </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select required v-model="producto"  class="form-control">
                                                <option disabled selected >Productos:</option>
                                                <option v-for="(producto,index) in productos" v-bind:key="index" v-bind:value="index">
                                                    {{ producto.nombre }}
                                                </option>
                                        </select>
                                    </div>                                         
                                    <div class="col-md-2">
                                        <input required  min="1"  pattern="^[0-9]+" type="number" class="form-check-input" id="exampleCheck1"  v-model="cantidad">
                                    </div>
                                    <div class="col-md-2">
                                       
                                        <button type="button"  v-on:click= "agregarProducto()" :disabled="1==3" class="btn btn-success">+</button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="container color2">
                                            <br>
                                            <div v-for="(producto,index) in seleccionados" v-bind:key="index">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <p>* {{productos[producto].id}}-{{productos[producto].nombre}}</p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" :value="index"  v-on:click= "quitarProducto(index)" class="btn btn-danger">-</button>
                                                    </div>
                                                </div>
                                            </div>
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
                codigosDeClientes:[],
                cantidad: ""
            }
        },
        mounted() { 
            console.log('Component mounted.')
        },
        methods:{
            agregarProducto(){
                this.seleccionados.push(this.producto);
            },
            guardarCambios(){/*
                var params={
                    nombre: this.nombreMaterial,
                    codigoSiom: this.codigoSiomMaterial,
                    numeroPlano: this.numeroPlanoMaterial,
                    descripcion: this.descripcionMaterial,
                    tipoMaterial: this.tipoMaterialMaterial
                }
                axios
                    .post('http://localhost:8000/producto/', params)
                    .then(response => {
                        //actualizar los data con defecto, o algo asi quizas o ek key
                        console.log(response.data);
                        $('#modalCreateMaterial').modal('hide');
                        $('.modal-backdrop').hide();
                        this.$emit('botonGuardarCreacionMaterial');
                        alert("Material creado exitosamente");
                    })*/
            }
        }
    }
</script>