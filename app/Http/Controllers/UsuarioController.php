<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Rol;
use App\RolUsuario;
use App\Area;
use App\Estacion;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerTrabajadoresPorEstacion($id){
        $estacion = Estacion::where('id',$id)->get();
        $area = $estacion[0]->area;
        $usuarios = $area->usuarios;
        $trabajadores = array();
        $idRol = Rol::where('nombre',"rol 1")->first(); //ojo con esto, queda estatico.
        foreach ($usuarios as $usuario){
            $rolesUsuario = RolUsuario::where('usuario_id',$idRol->id)->get();
            foreach($rolesUsuario as $rolUsuario){
                if($rolUsuario->rol_id == $idRol->id){ 
                    $trabajadores[] = $usuario;
                }
            }
        }
        return $trabajadores;
    }
 
    public function obtenerTrabajadores()
    {
        $rol = Rol::where('nombre', "trabajador")->get();
        //echo $rol[0];
        $usuarios = Usuario::all();
        //echo $rol[0]->usuarios;
        return $rol[0]->usuarios;
       
        
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
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
