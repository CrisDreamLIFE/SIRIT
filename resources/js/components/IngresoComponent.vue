<template>
    <div v-if="!logeado">
        <p>Bienvenido al Sistema de Recopilación de Trabajo (SIRIT), para continuar Ingrese su RUT:</p>
        <div class="container color">
            <form action="">
                <div class="form-row">
                    <div class="col-sm-6">
                        <label class= "lavelFont font-weight-bold" >Ingrese Rut:</label>
                    </div>
                    <div class="col-sm-6"> 
                        <label class= "lavelFont font-weight-bold" >Ingrese Contraseña:</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-6">
                        <input @input="validarRut(rut)" placeholder="11.222.333-4" class="form-control" type="text"  v-model="rut">
                    </div>
                    <div class="col-sm-6">
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
    </div>
    <div  v-else> 
        <div v-if="!iniciarTrabajoBool">
            <principal-menu-component
            @botonIniciarTrabajo="iniciarTrabajo"
            :usuario = "usuario"
            :roles = "roles">
            </principal-menu-component>
            <!--<principal-work-component
            :estaciones = "estaciones"
            :ots = "ots">
            </principal-work-component>-->
        </div>
        <div :key='componentKey' v-else>
            <principal-work-component
            @terminarTrabajo="forceRender"
            :estaciones = "estaciones"
            :ots = "ots">
            </principal-work-component>
        </div> 
    </div>

</template>

<script>
export default {
        data(){
            return {
                usuario: null,
                roles:[],
                logeado: false,
                rut: null,
                contraseña:null,
                estaciones:[],
                ots:[],
                iniciarTrabajoBool: false,
                componentKey:0
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
            forceRerender(){
                this.componentKey += 1;  
            },
            iniciarTrabajo(){
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
                                aux.push(response.data.usuario.roles[i].nombre);
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
</style>