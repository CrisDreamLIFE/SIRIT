<template>
    <div v-if="!logeado">
        <br>
        <div class="container text-center">
            <h2>Bienvenido al Sistema de Recopilación de Información de Trabajo (SIRIT)</h2>
        </div>
        <br><br>
        <div class="container wrapper fadeInDown " id="formContent">
            
            <form action="">
                <br>
                <div class="form-row">
                    <div class="col-sm-7">
                        <label class= "lavelFont font-weight-bold" >Ingrese Rut:</label>
                    </div>
                    <div class="col-sm-5">
                        <input @input="validarRut(rut)" placeholder="11.222.333-4" class="form-control" type="text"  v-model="rut">
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="col-sm-7"> 
                        <label class= "lavelFont font-weight-bold" >Ingrese Contraseña:</label>
                    </div>
                    <div class="col-sm-5">
                        <input  class="form-control" type="password" v-model="contraseña">
                    </div>
                </div>
                <br>
                <div class="form-row justify-content-center">
                    <div class="col-sm-12 justify-content-center">
                        <button type="button" v-on:click="logear" class="btn btn-success btn-lg colorBoton">Ingresar</button>
                    </div>
                </div>
                <br>
            </form>
        </div>
        <br><br><br><br><br>
    </div>
    <div  v-else> 
        <div v-if="!algoSeleccionado">
            <principal-menu-component
            @botonIniciarTrabajo="iniciarTrabajo"
            @botonGestionarOT="iniciarGestionOT"
            @botonGestionarMaterial="iniciarGestionMaterial"
            @botonGestionarSubMaterial="iniciarGestionSubMaterial"
            @botonGestionarReporte="iniciarGestionReporte"
            @botonGestionarUsuario="iniciarGestionUsuario"
            @cambioPais="cambioPais"
            @logout="logout"
            :usuario = "usuario"
            :roles = "roles"
            :pais = "pais">
            </principal-menu-component>
            <!--<principal-work-component
            :estaciones = "estaciones"
            :ots = "ots">
            </principal-work-component>-->
        </div>
        <div v-else  > <!--aqui mostramos los componentes de las acciones-->
            <!--------TRABAJO--------------------------->
            <div v-if="iniciarTrabajoBool">
                <principal-work-component
                :key="componentKey" 
                :estaciones = "estaciones"
                :ots = "ots"
                @botonGuardar="auxMetodo">
                </principal-work-component>
            </div>
            <!--------OT--------------------------->
            <div v-if="iniciarGestionOTBool">
                <principal-gestion-ot-component
                :otsTodas="otsTodas"
                :key="gestionOtN"
                @botonGuardarCreacionOt="recargarOt"
                @botonEliminarOt="recargarOt"
                @botonGuardarEdicionOt="recargarOt"
                @botonAtrasOt="botonAtrasOt">
                </principal-gestion-ot-component>
            </div>
            <!--------MATERIAL--------------------------->
            <div v-if="iniciarGestionMaterialBool">
                <principal-gestion-material-component
                :key="gestionMaterialN"
                :productos="productos"
                :subProductos="subProductos"
                @botonGuardarEdicionMaterial="recargarMateriales"
                @botonGuardarCreacionMaterial="recargarMateriales"
                @botonEliminarCreacionMaterial="recargarMateriales"
                @botonAtrasMaterial="botonAtrasMaterial"
                @botonEliminarProducto="recargarMateriales">
                </principal-gestion-material-component>
            </div>
            <!----------SUB-MATERIAL------------------------->
            <div v-if="iniciarGestionSubMaterialBool">
                <principal-gestion-sub-material-component
                :key="gestionSubMaterialN"
                :subProductos="subProductos"
                @botonGuardarEdicionSubMaterial="recargarSubMateriales"
                @botonGuardarCreacionSubMaterial="recargarSubMateriales"
                @botonEliminarCreacionSubMaterial="recargarSubMateriales"
                @botonAtrasSubMaterial="botonAtrasSubMaterial"
                @botonEliminarSubProducto="recargarSubMateriales">
                </principal-gestion-sub-material-component>
            </div>
            <!----------------USUARIOS------------------------->
            <div v-if="iniciarGestionUsuarioBool">
                <principal-gestion-usuario-component
                :key="gestionUsuarioN"
                :usuarios="usuarios"
                @botonGuardarEdicionUsuario="recargarUsuarios"
                @botonAtrasUsuario="botonAtrasUsuario">
                </principal-gestion-usuario-component>
            </div> 
            <!----------REPORTABILIDAD------------------------->
            <div v-if="iniciarGestionReporteBool">
                <principal-gestion-reporte-component
                :items="['julio','chico perez','el mismisimo','don este']"
                :key="gestionReporteN"
                :productos="productos"
                :ots="otsTodas[0]"
                :clientes="clientes"
                :responsables="responsables"
                :tipos="tipos"
                :estaciones="estaciones"
                :areas="areas"
                :naves="naves"
                @botonAtrasReporte="botonAtrasReporte">
                </principal-gestion-reporte-component>
            </div> 
            <!----------------------------------->
        </div> 
    </div>

</template>

<script>
export default {
        data(){
            return {
                usuario: null,
                componentKey: 0,
                gestionMaterialN:0,
                gestionSubMaterialN:0,
                gestionUsuarioN:0,
                gestionOtN:0,
                gestionReporteN:0,
                roles:[],
                logeado: false,
                rut: "19.313.751-2",
                contraseña:"11",
                estaciones:[],
                areas:[],
                naves:[],
                clientes:[],
                responsables:[],
                tipos:[],
                ots:[],
                otsTodas:[],
                productos:[],
                subProductos:[],
                usuarios:[],
                algoSeleccionado:false,
                iniciarTrabajoBool: false,
                iniciarGestionOTBool:false,
                iniciarGestionMaterialBool:false,
                iniciarGestionSubMaterialBool:false,
                iniciarGestionUsuarioBool: false,
                iniciarGestionReporteBool:false,
                componentKey:0,
                pais:""
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

            axios
            .get('http://localhost:8000/obtenerPais')
            .then(response => (this.pais = response.data.pais))
            console.log('Component mounted.')
        },
        methods:{ 
            logout(){
                this.logeado = false;
            },
            cambioPais(){
                axios
            .get('http://localhost:8000/otAbierta')
            .then(response => (this.ots = response.data))
            },
            botonAtrasUsuario(){
                this.iniciarGestionUsuarioBool = false;
                this.algoSeleccionado = false;
            },
            botonAtrasReporte(){
                this.iniciarGestionReporteBool = false;
                this.algoSeleccionado = false;
            },
            botonAtrasSubMaterial(){
                this.iniciarGestionSubMaterialBool = false;
                this.algoSeleccionado = false;
            },
            botonAtrasMaterial(){
                this.iniciarGestionMaterialBool = false;
                this.algoSeleccionado = false;
            },
            botonAtrasOt(){
                axios
            .get('http://localhost:8000/estacion')
            .then(response => (this.estaciones = response.data))
            console.log('Component mounted.')  

            axios
            .get('http://localhost:8000/otAbierta')
            .then(response => {this.ots = response.data
            this.iniciarGestionOTBool = false;
                this.algoSeleccionado = false;})
            console.log('Component mounted.')

            axios
            .get('http://localhost:8000/obtenerPais')
            .then(response => (this.pais = response.data.pais))
            console.log('Component mounted.')
                
            },
            recargarUsuarios(){
                console.log("ksi");
                axios
                .get('http://localhost:8000/usuario')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.usuarios = response.data
                    this.gestionUsuarioN +=1;
                    this.iniciarGestionUsuarioBool=true })
            },
            recargarOt(){
                axios
                .get('http://localhost:8000/ot')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.otsTodas = response.data
                    this.gestionOtN +=1;
                    this.iniciarGestionOTBool=true   }) 
            },
            recargarMateriales(){
                axios
                .get('http://localhost:8000/producto')
                .then(response =>{
                    this.productos= response.data;
                    console.log("recargue los materiales ;v");
                    this.gestionMaterialN +=1;
                    this.iniciarGestionMaterialBool=true;
                    console.log(this.gestionMaterialN);
                })
                
            },
            recargarSubMateriales(){
                axios
                .get('http://localhost:8000/subProducto')
                .then(response =>{
                    this.subProductos= response.data;
                    console.log("recargue los materiales ;v");
                    this.gestionSubMaterialN +=1;
                    this.iniciarGestionSubMaterialBool=true;
                })
            },
            auxMetodo(){
                console.log("entre al auuuux");
                this.componentKey += 1;    
            },
            iniciarGestionReporte(){
                 axios
                .get('http://localhost:8000/nave')
                .then(response =>{
                    console.log(response.data)
                    this.naves=response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true;})
                axios
                .get('http://localhost:8000/area')
                .then(response =>{
                    console.log(response.data)
                    this.areas=response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true;})
                axios
                .get('http://localhost:8000/producto')
                .then(response =>{
                    console.log(response.data)
                    this.productos=response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true;})
                axios
                .get('http://localhost:8000/ot')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.otsTodas = response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true
                    }) 
                axios
                .get('http://localhost:8000/cliente')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.clientes = response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true
                    })
                axios
                .get('http://localhost:8000/obtenerGestores')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.responsables = response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true
                    })
                axios
                .get('http://localhost:8000/otTipo')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.tipos = response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionReporteBool=true
                    })     
            },
            iniciarGestionMaterial(){
                axios
                .get('http://localhost:8000/producto')
                .then(response =>{
                    console.log(response.data)
                    this.productos=response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionMaterialBool=true;}) 
            },
            iniciarGestionSubMaterial(){
                axios
                .get('http://localhost:8000/subProducto')
                .then(response =>{
                    console.log(response.data)
                    this.subProductos =response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionSubMaterialBool=true;}) 
            },
            iniciarGestionUsuario(){
                axios
                .get('http://localhost:8000/usuariosConRol')
                .then(response =>{
                    console.log(response.data)
                    this.usuarios =response.data;
                    this.algoSeleccionado=true;
                    this.iniciarGestionUsuarioBool=true;}) 
            },
            iniciarGestionOT(){
                axios
                .get('http://localhost:8000/ot')
                .then(response =>{
                    console.log("respuesta de ot:")
                    console.log(response.data)
                    this.otsTodas = response.data
                    this.algoSeleccionado=true;
                    this.iniciarGestionOTBool=true;})
            },
            iniciarTrabajo(){
                this.algoSeleccionado=true;
                this.iniciarTrabajoBool=true;
            },
            logear(){
                console.log("ahora me logeo:v")
                if(!this.validarRut(this.rut)){
                    console.log("rut malo");
                }
                else{
                    console.log("rut bueno");
                    var params = {
                        rut: this.rut,
                        contraseña: this.contraseña
                        };
                    axios
                    .post('http://localhost:8000/usuarios/login', params)
                    .then(response => {
                        console.log("respuesta");
                        console.log(response.data);
                        if(response.data==0){
                            console.log("no se encontro usuario");
                        }
                        else if(response.data==1){
                            console.log("contraseña invalida");
                        }
                        else{
                            this.usuario=response.data.usuario;
                            var aux=[]
                            for(var i =0;i< response.data.usuario.roles.length;i++){
                                aux.push(response.data.usuario.roles[i].nombre_rol);
                            }
                            this.roles = aux;
                            this.logeado = true;
                        }
                        })
                }
            },
            validarRut(rut){
                // Despejar Puntos
                var valor = rut.replace('.','');
                // Despejar Guión
                valor = valor.replace('-','');
                for (var i = 0; i < valor.length; i++) {
                    //valor = valor.replace('.','');
                    //valor = valor.replace('-','');
                    valor = valor.replace(/[^0-9\K\k]/g,'');
                    }
                // Aislar Cuerpo y Dígito Verificador
                var cuerpo = valor.slice(0,-1);
                var dv = valor.slice(-1).toUpperCase();
                
                // Formatear RUN
                var rut_value = cuerpo + '-'+ dv
                
                // Si no cumple con el mínimo ej. (n.nnn.nnn)
                if(cuerpo.length < 7) { 
                    //rut.setCustomValidity("RUT Incompleto"); 
                    console.log("no cumple el minimo");
                    return false;
                }
                
                // Calcular Dígito Verificador
                var suma = 0;
                var multiplo = 2;
                
                // Para cada dígito del Cuerpo
                for(var i=1;i<=cuerpo.length;i++) {
                    console.log(i);
                    // Obtener su Producto con el Múltiplo Correspondiente
                    var index = multiplo * valor.charAt(cuerpo.length - i);
                    console.log("index: "+index);
                    // Sumar al Contador General
                    suma = suma + index;
                    
                    // Consolidar Múltiplo dentro del rango [2,7]
                    if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
            
                }
                
                // Calcular Dígito Verificador en base al Módulo 11
                var dvEsperado = 11 - (suma % 11);
                
                // Casos Especiales (0 y K)
                dv = (dv == 'K')?10:dv;
                dv = (dv == 0)?11:dv;
                
                // Validar que el Cuerpo coincide con su Dígito Verificador
                if(dvEsperado != dv) { 
                    //rut.setCustomValidity("RUT Inválido"); 
                    console.log("no coincide con el digito verificador");
                    console.log(dvEsperado);
                    console.log(dv);
                    return false; 
                }
                return true;
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
    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column; 
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
        border: 2px solid #000;
    }
    #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background-color:#3c70a4;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        text-align: center;
        }
    
</style>