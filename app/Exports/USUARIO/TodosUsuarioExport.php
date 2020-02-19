<?php

namespace App\Exports\USUARIO;

use App\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TodosUsuarioExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        $usuarioCompleto = Usuario::join("rol_usuarios","usuarios.id","=","rol_usuarios.usuario_id")
                        ->join("rols", "rols.id","=","rol_usuarios.rol_id")
                        ->select('usuarios.nombre_usuario','usuarios.rut','usuarios.activo','usuarios.area',
                        'rols.nombre_rol')
                        ->get();
            
        foreach($usuarioCompleto as $usuario){
            if($usuario->activo){
                $usuario->activo = "ACTIVO";
            }
            else{
                $usuario->activo = "INACTIVO";
            }
        } 
            return $usuarioCompleto;

       }

    public function headings(): array
    {
        return [
            'NOMBRE',
            'RUT',
            'ESTADO',
            'AREA' ,
            'ROL'
        ];
    }
}
