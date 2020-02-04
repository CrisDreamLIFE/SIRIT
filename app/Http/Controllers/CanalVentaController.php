<?php

namespace App\Http\Controllers;

use App\CanalVenta;
use Illuminate\Http\Request;

class CanalVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = CanalVenta::all();
        return $todos;
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
     * @param  \App\CanalVenta  $canalVenta
     * @return \Illuminate\Http\Response
     */
    public function show(CanalVenta $canalVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CanalVenta  $canalVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(CanalVenta $canalVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CanalVenta  $canalVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CanalVenta $canalVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CanalVenta  $canalVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(CanalVenta $canalVenta)
    {
        //
    }
}
