<template>
    <div class="margen">
        <br>
        <div class="row container">
            <div class="col-sm-2"><!--colorBoton-->
                <button type="button" v-on:click="volverMenu" class="btn btn-secondary  btn-block colorBoton">Atrás</button>
            </div>
        </div>
        <br>
        <div class="row container">
            <div class="col-sm-4">
                <button type="button" @click="crearUsuario()" data-target="#modalCreateUsuario" data-toggle="modal" class="btn btn-lg btn-block btn-success">Nuevo Usuario</button>
            </div>
            <div class="com-sm-6">
                <div class="row"> <!-- este es el buscador, lo vemos mas tarde o altiro mejor-->
                    <div class="col-sm">
                        <input id="7" class="form-control form-control-lg form-control-borderless" placeholder="Nombre Usuario" type="search" v-model="searchUsuario" @input="onChangueUsuario"/>
                    </div>
                    <!--end of col-->
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <input class="form-check-input" :value="true" :unchecked-value="true" v-model="activo" id="activo" type="checkbox">
                        <label style="font-size:18px" for = "activo">{{'   activo'}}</label> 
                    </div>
                 </div>    
            </div>
        </div>
        <br>
        <div v-if="crearUsuarioBool"> <!-- CREATE -->
                <modal-usuario-create-component 
                    :key="creacionN"
                    :areas="areas"
                    :roles="roles"
                    @botonGuardarCreacionUsuario="guardarCreacionUsuario">
                    </modal-usuario-create-component>
                </div>
                <div v-if="editarUsuarioBool"> <!-- EDIT --> 
                    <modal-usuario-edit-component
                    :key="edicionN"
                    :areas="areas"
                    :roles="roles"
                    :usuarioSeleccionado="usuarioSeleccionado"
                    @botonGuardarEdicionUsuario="guardarEdicionUsuario">
                    </modal-usuario-edit-component> 
                </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm-3"><h6 align="center">Nombre</h6></div>
                <div class="col-sm-1"><h6 align="center">Área</h6></div>    
                <div class="col-sm-1"><h6 align="center">Rol</h6></div>
                <div class="col-sm-1"><h6 align="center">Estado</h6></div>
                <div class="col-sm-2"><h6 align="center">Descripción</h6></div>
                <div class="col-sm-2"><h6 align="center">Acciones</h6></div>
            
            </div>    
            <hr style="border:1px dotted #64b2cd; " />
            <div v-for="(usuario,index1) in resultsUsuario" :key="index1">
                    <div v-if="(activo==true && usuario.activo==1)||(activo==false && usuario.activo==0)" class="row">
                        <div align="center" class="col-sm-3">{{usuario.nombre_usuario}}</div>
                        <div class="col-sm-1">
                            <div  v-for="(area,index2) in usuario.areas" :key="index2">
                                <p align="center">{{area.nombre_area}}</p>      
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div  v-for="(rol,index3) in usuario.roles" :key="index3">
                                <p align="center">{{rol.nombre_rol}}</p>      
                            </div>
                        </div>
                        <div class="col-sm-1"> 
                            <p v-if="usuario.activo==1" align="center">Activo</p>
                            <p v-else align="center">Inactivo</p>
                        </div>
                        <div align="center" class="col-sm-2">{{usuario.descripcion}}</div>
                        <div class="col-sm-1">
                            <button type="button" data-toggle="modal" data-target="#modalEditUsuario" @click="editarUsuario(usuario)" class="btn btn-warning">editar</button>
                        </div>
                        <div class="col-sm-1">
                            <button v-if="usuario.activo==1" type="button" @click="inactivarUsuario(usuario)" class="btn btn-danger">Inactivar</button>
                            <button v-if="usuario.activo==0" type="button" @click="activarUsuario(usuario)" class="btn btn-success">Activar</button>
                        </div>
                        
                    </div>
                
                <hr v-if="(activo==true && usuario.activo==1)||(activo==false && usuario.activo==0)" style="border:1px dotted gray; " />
                </div>
            </div>
        </div>   
    
</template>

<script>
    export default {
        props: ['usuarios'], 
        data(){
            return {
                creacionN:0,
                edicionN:0,
                crearUsuarioBool:false,
                editarUsuarioBool:false,
                activo: true,
                searchUsuario:"",
                resultsUsuario: this.usuarios,
                areas:[],
                roles:[],
                usuarioSeleccionado:""

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
             volverMenu(){
                this.$emit('botonAtrasUsuario')
            },
            onChangueUsuario(){
                        console.log("usuarios:");
                        console.log(this.usuarios);
                        this.filterResultsUsuario();
                    },
            filterResultsUsuario(){
                this.resultsUsuario = this.usuarios.filter(item => item.nombre_usuario.toLowerCase().indexOf(this.searchUsuario.toLowerCase())>-1);
                //esta hay que cambiarla.
            },
            crearUsuario(){
                //cargar 6 cosas:
                //canal de venta
                console.log("entre")
                axios
                    .get('http://localhost:8000/area/')
                    .then(response => {this.areas=response.data;})
                axios
                    .get('http://localhost:8000/rol/')
                    .then(response => {this.roles=response.data;})

                this.crearUsuarioBool=true; 
            },
            editarUsuario(usuario){
                this.edicionN = this.edicionN + 1;
                this.usuarioSeleccionado = usuario;
                axios
                    .get('http://localhost:8000/area/')
                    .then(response => {this.areas=response.data;})
                axios
                    .get('http://localhost:8000/rol/')
                    .then(response => {this.roles=response.data;})
               
                this.editarUsuarioBool=true;    
            },
            activarUsuario(usuario){
                axios
                .get('http://localhost:8000/activarUsuario/'+ usuario.id) 
                            .then(response => {
                                console.log(response);
                                 axios
                                    .get('http://localhost:8000/usuariosConRol')
                                    .then(response =>{
                                        console.log(response.data)
                                        this.resultsUsuario =response.data;})
                                //alert("OT eliminada exitosamente");
                                //this.$emit('botonEliminarOt')
                                //this.abierta=true;
                                })
            },
            inactivarUsuario(usuario){
                axios
                .get('http://localhost:8000/inactivarUsuario/'+ usuario.id) 
                            .then(response => {
                                console.log(response);
                                axios
                                    .get('http://localhost:8000/usuariosConRol')
                                    .then(response =>{
                                        console.log(response.data)
                                        this.resultsUsuario =response.data;})
                                //alert("OT eliminada exitosamente");
                                //this.$emit('botonEliminarOt')
                                //this.abierta=false;
                                })
                                //this.abierta=false;
            },
            guardarCreacionUsuario(){
                console.log("este nivel");
                
                 this.$emit('botonGuardarCreacionUsuario');
            },
            guardarEdicionUsuario(){
                console.log("evento del principal");
                this.$emit('botonGuardarEdicionUsuario');    
            }
        }
    }
</script>