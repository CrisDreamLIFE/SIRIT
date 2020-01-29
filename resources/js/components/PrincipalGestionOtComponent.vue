<template>
    <div class="container">
        <div v-if="masInformacionBool"><!--modal SHOW -->
            <modal-ot-component
            :ot="otsTodas[indexOt]"
            :productos="productos"
            :cantidadXProducto="cantidadXProducto"
            :cliente="cliente"
            :canalVenta="canalVenta"
            :tipoOt="tipoOt"
            :responsable="responsable"></modal-ot-component>
        </div>
        <div class="card card-body" > 
            <div class="row">
                <div class="col-sm"><h3>OT</h3></div>
                <div class="col-sm"><h3>Fecha Recepción</h3></div>    
                <div class="col-sm"><h3>Estado</h3></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>   
            </div>    
            <div v-for="(ot,index) in otsTodas" :key="index">
                <div class="row">
                    <div class="col-sm">{{ot.id}}</div>
                    <div class="col-sm">{{ot.fecha_recepcion}}</div>
                    <div class="col-sm"><span v-if="ot.abierta==1">Abierta</span><span v-else>Cerrada</span></div>
                    <div class="col-sm">
                        <button type="button" data-toggle="modal" data-target="#exampleModal"  @click="masInformacion(index)" class="btn btn-info">informacion</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" data-toggle="modal" data-target="#exampleModal2" @click="editarOt(index)" class="btn btn-warning">editar</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-danger">eliminar</button>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</template>

<script>
    export default {
        props: ['otsTodas'], 
        data(){
            return {
                masInformacionBool: false,
                indexOt:null,
                productos:[],
                cantidadXProducto:[],
                cliente:{nombre:""},
                canalVenta:{nombre:""},
                tipoOt:{nombre:""},
                responsable:{nombre:""},
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            masInformacion(index){
                console.log("mostare el modal")
                this.indexOt=index;
                //hacer todos los get de la ot (cliente por ejempplo)
                //Productos:
                axios
                    .get('http://localhost:8000/productosYCantidadOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.productos=response.data.productos;
                        this.cantidadXProducto=response.data.cantidades;
                        
                        })
                //Cliente
                axios
                    .get('http://localhost:8000/obtenerClienteOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.cliente =response.data;
                        
                        })
                //CanalVenta
                axios
                    .get('http://localhost:8000/obtenerCanalOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.canalVenta =response.data;
                        
                        })
                //TIPO OT
                axios
                    .get('http://localhost:8000/obtenerTipoOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.tipoOt =response.data;
                        })
                axios
                    .get('http://localhost:8000/obtenerResponsableOt/'+this.otsTodas[index].id)
                    .then(response => {
                        console.log(response)
                        this.responsable =response.data;
                        })
                  this.masInformacionBool=true;  
                //////////////////////////////////////////////////////// 
                //abrir su modal
            }
        }
    }
</script>