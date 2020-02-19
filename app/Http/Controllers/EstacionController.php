<?php

namespace App\Http\Controllers;

use App\Estacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ESTACION\TodasExport;

class EstacionController extends Controller
{
    public function exportarExcel(Request $request){
        $opcion = $request->input('opcion');
        $operacion = $request->input('operacion');
        $cuerpo = $request->input('cuerpo');
        $abierta = $request->input('abierta');
        $cerrada = $request->input('cerrada');

        error_log("opcion:");
        error_log($opcion);
        if($opcion=="1"){error_log("opcion de la 1o"); return Excel::download(new TodasExport(),'ot-list.xlsx');}
       // if($opcion=="2"){error_log("opcion de la 2"); return Excel::download(new AreaExport($operacion,$cuerpo),'ot-list.xlsx');}
    } 

    public function index()
    {
        $estaciones = Estacion::all();
        /*return view('principal')->with([
            'estaciones'=>$estaciones
        ]);*/
        return $estaciones;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estacion  $estacion
     * @return \Illuminate\Http\Response
     */
    public function show(Estacion $estacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estacion  $estacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Estacion $estacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estacion  $estacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estacion $estacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estacion  $estacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estacion $estacion)
    {
        //
    }
}
