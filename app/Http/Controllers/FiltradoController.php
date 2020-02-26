<?php

namespace App\Http\Controllers;

use App\Filtrado;
use Illuminate\Http\Request;

class FiltradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerPais(){
        $aux = Filtrado::first();
        return $aux;
    }

    public function cambiarPais(Request $request){
        $pais = $request->input('pais');
        $filtrado = Filtrado::first();
        error_log("esdfsd");
        error_log($filtrado);
        $filtrado->pais = $pais;
        $filtrado->save();
        return $filtrado->pais;
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Filtrado  $filtrado
     * @return \Illuminate\Http\Response
     */
    public function show(Filtrado $filtrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Filtrado  $filtrado
     * @return \Illuminate\Http\Response
     */
    public function edit(Filtrado $filtrado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filtrado  $filtrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filtrado $filtrado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Filtrado  $filtrado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filtrado $filtrado)
    {
        //
    }
}
