<?php

namespace App\Http\Controllers;

use App\TipoMaterial;
use Illuminate\Http\Request;

class TipoMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerIdFiltrador()
    {
        $tipoFiltrador = TipoMaterial::where('detallePieza',1)->get();
        return $tipoFiltrador[0]->id;
    }

    public function index()
    {
        $materiales = TipoMaterial::all();
        return $materiales;
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
     * @param  \App\TipoMaterial  $tipoMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(TipoMaterial $tipoMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoMaterial  $tipoMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoMaterial $tipoMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoMaterial  $tipoMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoMaterial $tipoMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoMaterial  $tipoMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoMaterial $tipoMaterial)
    {
        //
    }
}
