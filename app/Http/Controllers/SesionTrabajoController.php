<?php

namespace App\Http\Controllers;

use App\SesionTrabajo;
use App\SesionTrabajoUsuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SesionTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeFinal(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        error_log("111111111");
        $estacion_id = $request->input('id_estacion');
        $trabajadoresArray = $request->input('trabajadores');
        $fechaActual = Carbon::now();
        error_log("2222");       
        

        #creamos la sesion
        error_log("3333");
        $sesion = new SesionTrabajo;
         
        $sesion->estacion_id = $estacion_id;
        error_log("44"); 
        $sesion->fecha_inicio = $fechaActual;
        $sesion->hora_inicio = $fechaActual;
        $sesion->save();

        error_log("555");  

        #creamos la sesion-usuario
        foreach($trabajadoresArray as $trabajador ){
            $nuevo = new SesionTrabajoUsuario;
            error_log("666"); 
            $nuevo->usuario_id = $trabajador['id']; //aqui se cae
            error_log("777"); 
            $nuevo->sesion_trabajo_id = $sesion->id;
            error_log("888"); 

            $nuevo->save();
        }

        return $sesion->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SesionTrabajo $sesionTrabajo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SesionTrabajo  $sesionTrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SesionTrabajo $sesionTrabajo)
    {
        //
    }
}
