<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Rol;
use App\RolUsuario;
use App\Area;
use App\AreaUsuario;
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
        $usuario = Usuario::where('rut', $rut)->where('activo',1)->get();
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
            if($usuario->activo==1){
                $rolesUsuario = RolUsuario::where('usuario_id',$usuario->id)->get();
                foreach($rolesUsuario as $rolUsuario){
                    if($rolUsuario->rol_id == 4){ 
                        $trabajadores[] = $usuario;
                    }
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

    public function activarUsuario($id){
        error_log("a");
        $usuario = Usuario::find($id);
        $usuario->activo = true;
        $usuario->save();
    }

    public function inactivarUsuario($id){
        error_log("1");
        $usuario = Usuario::find($id);
        $usuario->activo = false;
        $usuario->save();
        error_log($usuario->activo);
    }

    public function usuariosConRol(){
        $usuarios = Usuario::all();
        foreach($usuarios as $usr){
            $roles = $usr->roles;
            /*foreach($roles as $rol){
                $aux = new Object_();
                $rolEntero = Rol::find($rol->id);
                $aux->id = $rol->id;
                $aux->nombre = $rol->nombre_rol;
                $rol = $aux;
            }*/
            $areas = $usr->areas;
        }
        return $usuarios;
    }
    public function index()
    {
        $usuarios =Usuario::orderBy('nombre_usuario')->get();
        foreach($usuarios as $usu){
            $usu->roles;
            $usu->areas;
        }
        return $usuarios;
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
        $nombre = $request->input('nombre');
        $rut = $request->input('rut');
        $pass = $request->input('pass');
        $areasArray = $request->input('areas');
        $rolesArray = $request->input('roles');

        #para usuario
        $usuario = new Usuario;
        error_log($usuario);
        $usuario->nombre_usuario = $nombre;
        $usuario->rut = $rut;
        $usuario->contraseña = $pass;
        $usuario->activo = true;
        $areak = '';
        $usuario->save();
        $usuario = Usuario::where('rut',$rut)->where("activo",1)->where('contraseña',$pass)->where("nombre_usuario",$nombre)->get();
        $usuario = $usuario[0];
        error_log($usuario);
        error_log("para los roles");
        #para roles
        foreach($rolesArray as $rol){
            $rolUsuario = new RolUsuario;
            $rolUsuario->usuario_id = $usuario->id;
            $rolUsuario->rol_id = $rol['id'];
            $rolUsuario->save();
        }
        error_log("para las areas");
        #para areas
        $primero = 1;
        foreach($areasArray as $area){
            $areaUsuario = new AreaUsuario;
            $areaUsuario->usuario_id = $usuario->id;
            $areaUsuario->area_id = $area['id'];
            error_log("a");
            if($primero ==1){
                error_log($area['nombre_area']);
                $areak = $areak . $area['nombre_area'];
                error_log($areak);
            }
            else{
                $areak=$areak . ', ' . $area['nombre_area'];
            }
            error_log("b");
            $areaUsuario->save();
            $primero = 0;
        }

        $usuario->area = $areak;
        error_log($usuario->area);
        error_log("antes del save");
        $usuario->save();
        return 'OK';

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
        error_log("entre?");
        $nombre = $request->input('nombre');
        $rut = $request->input('rut');
        $pass = $request->input('pass');
        $areasArray = $request->input('areas');
        $rolesArray = $request->input('roles');
        $areasViejasArray = $request->input('areasViejas');
        $rolesViejosArray = $request->input('rolesViejos');
        $estado = $request->input('estado');
        error_log("1");
        error_log($usuario);

        #para usuario
        $usuario = Usuario::where('rut',$usuario->rut)->where("activo",$usuario->activo)->where('contraseña',$usuario->contraseña)->where("nombre_usuario",$usuario->nombre_usuario)->get();
        if(count($usuario)==0){error_log("no lo pillé");}
        $usuario = $usuario[0];
        error_log("2");
        $usuario->nombre_usuario = $nombre;
        $usuario->rut = $rut;
        $usuario->contraseña = $pass;
        if($estado){$usuario->activo = true;}
        else{$usuario->activo = false;}
        $areak = '';
        
        
        error_log($usuario);
        error_log("para los roles");
        error_log($rolesViejosArray[0]['id']);
        #para roles
        #borramos los viejos:
        foreach($rolesViejosArray as $rolViejo){
            error_log($rolViejo['nombre_rol']);
            $aux = RolUsuario::where('rol_id',$rolViejo['id'])->where('usuario_id',$usuario->id)->get();
            error_log($aux);
            if(count($aux)>0){
                $aux[0]->delete();
            }
        }
        #guardamos los nuevos
        foreach($rolesArray as $rol){
            $rolUsuario = new RolUsuario;
            $rolUsuario->usuario_id = $usuario->id;
            $rolUsuario->rol_id = $rol['id'];
            $rolUsuario->save();
        }
        error_log("para las areas");
        #para areas
        #borramos los viejas:
        foreach($areasViejasArray as $areaVieja){
            $aux = AreaUsuario::where('area_id',$areaVieja['id'])->where('usuario_id',$usuario->id)->get();
            if(count($aux)>0){
                $aux[0]->delete();
            }
        }
        $primero = 1;
        foreach($areasArray as $area){
            $areaUsuario = new AreaUsuario;
            $areaUsuario->usuario_id = $usuario->id;
            $areaUsuario->area_id = $area['id'];
            error_log("a");
            if($primero ==1){
                error_log($area['nombre_area']);
                $areak = $areak . $area['nombre_area'];
                error_log($areak);
            }
            else{
                $areak=$areak . ', ' . $area['nombre_area'];
            }
            error_log("b");
            $areaUsuario->save();
            $primero = 0;
        }

        $usuario->area = $areak;
        error_log($usuario->area);
        error_log("antes del save");
        $usuario->save();
        return 'OK';
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
