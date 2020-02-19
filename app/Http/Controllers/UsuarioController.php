<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Rol;
use App\RolUsuario;
use App\Area;
use App\Estacion;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TRABAJADOR\TodasExport;
use App\Exports\USUARIO\TodosUsuarioExport;

class UsuarioController extends Controller
{
    public function exportarExcelUsuario(Request $request){
        $opcion = $request->input('opcion');
        $operacion = $request->input('operacion');
        $cuerpo = $request->input('cuerpo');
        $abierta = $request->input('abierta');
        $cerrada = $request->input('cerrada');

        error_log("opcion:");
        error_log($opcion);
        if($opcion=="1"){error_log("opcion de la 1o"); return Excel::download(new TodosUsuarioExport(),'ot-list.xlsx');}
       // if($opcion=="2"){error_log("opcion de la 2"); return Excel::download(new AreaExport($operacion,$cuerpo),'ot-list.xlsx');}
    }

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

    public function buscarConRut(Request $request){
        $rut = $request->input('rut');
        $pass = $request->input('contraseña');
        $usuario = Usuario::where('rut', $rut)->get();
        if($usuario->isEmpty()){
            return 0;
        }
        
        elseif($usuario->first()->contraseña != $pass){
            return 1;
        }
        else{
            $allData = new Object_();  
            $usuario = $usuario->first();
            $roles = $usuario->roles;
            $allData->usuario = $usuario;
            //$allData->roles = $roles;
            $allData = json_encode($allData);
            return $allData;
        }
        
    }

    public function obtenerTrabajadoresPorEstacion($id){
        $estacion = Estacion::where('id',$id)->get();
        $area = $estacion[0]->area;
        $usuarios = $area->usuarios;
        $trabajadores = array();
        $idRol = 4; //ojo con esto, queda estatico.
        foreach ($usuarios as $usuario){
            $rolesUsuario = RolUsuario::where('usuario_id',$usuario->id)->get();
            foreach($rolesUsuario as $rolUsuario){
                if($rolUsuario->rol_id == 4){ 
                    $trabajadores[] = $usuario;
                }
            }
        }
        return $trabajadores;
    }
 
    public function obtenerTrabajadores()
    {   
        $final = array();
        $usuarios = Usuario::join("rol_usuarios","usuarios.id","=","rol_usuarios.usuario_id")
        ->where("rol_usuarios.rol_id",4)->get();
        foreach($usuarios as $u){
            $aux = Usuario::find($u->usuario_id);
            $final[] = $aux;
            error_log("dsfsd");
        }
        return $final;
        /*$rol = Rol::where('nombre', "operador")->get();
        //echo $rol[0];
        $usuarios = Usuario::all();
        //echo $rol[0]->usuarios;
        return $rol[0]->usuarios;*/
       
        
    }

    public function obtenerGestores()
    {
        $final = array();
        $usuarios = Usuario::join("rol_usuarios","usuarios.id","=","rol_usuarios.usuario_id")
        ->where("rol_usuarios.rol_id",1)->get();
        foreach($usuarios as $u){
            $aux = Usuario::find($u->usuario_id);
            $final[] = $aux;
            error_log("dsfsd");
        }
        return $final;
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
