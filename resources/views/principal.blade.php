@extends('plantilla')

@section('content')
        <!-- Just an image -->
    <nav class="navbar navbar-light  colorNav">
      <a class="navbar-brand" href="#">
        <img src="https://siom.bigscience.cl/wp-content/uploads/2019/10/LOGO-SIOM-OFICIAL-2018_Mesa-de-trabajo-1.png" width="50" height="50" alt="">
      </a>
    </nav>
    <div class= "container">
        <br>
        <h2 class="h2">Especificaciones del Trabajo:</h2>
        <div class="container color">
            <form>
                <div class="form-group">
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Estación:</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Estación 1</option>
                                <option>José Cousiño Tapia</option>
                                <option>Cristóbal Serrano Verdugo</option>>h
                            </select>  
                    
                        </div>
                        <div class="col-sm-6">
                            <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Trabajadores:</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Camilo Pino Olmos</option>
                                <option>José Cousiño Tapia</option>
                                <option>Cristóbal Serrano Verdugo</option>
                                <option>Manuel Veloso Figueroa</option>
                                <option>Roberto Labra Mancilla</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione OT:</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>2010</option>
                                <option>2020</option>
                                <option>2466</option>>
                                <option>2530</option>
                                <option>3195</option>
                            </select>
                        </div>
                            <div class="col-sm-6">

                                <label class= "lavelFont font-weight-bold" for="exampleFormControlSelect1">Seleccione Producto:</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Malla con Dam</option>
                                    <option>Producto 2</option>
                                    <option>Producto 3</option>>
                                    <option>Producto 4</option>
                                    <option>Producto 5</option>
                                </select>
                            </div>
                        </div>
                    <br>                   
                </div>
            </form>
        </div>
        <br><br>
        <div class="row">
            <div class="col-sm-6">
                <h2 class="h2">Lista de trabajadores seleccionados:</h2>
                <div class="container color2">
                    sdfdsf
                    <br><br><br><br><br><br>
                </div>
            </div>
            <div class="col-sm-6">
                <h2 class="h2">Lista de OTs seleecionadas:</h2>
                <div class="container color2">
                    aaaa
                    <br><br><br><br><br><br><br>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row justify-content-center">
            <button type="button" class="colorBoton btn-primary btn ">Primary</button>
        </div>
        
        <br><br><br><br>
        <example-component></example-component><!--Añadimos nuestro componente vuejs-->

        
@endsection

<style>
    .color{
        margin-top:  20px;
        background-color:3c70a4;
        border-color: 64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
    }
    .color2{
        margin-top:  20px;
        background-color:ffffff;
        border-color: 64b2cd;
        border-radius: 5px;
        border: 2px solid #000;
        color: 3c70a4;
    }
    .lavelFont{
        font-size: 20px;
        color: da9833;
    }
    .colorNav{
        background-color: 64b2cd;
    }
    .h2{
        color: 3c70a4;
    }
    .colorBoton{
        color:white;
        background:#638cb5;
    }
</style>


