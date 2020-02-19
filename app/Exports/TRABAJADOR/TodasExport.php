<?php

namespace App\Exports\TRABAJADOR;

use App\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TodasExport implements FromCollection, WithHeadings
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

        $return = $usuarioCompleto->filter(function ($item) {
                if($item->nombre_rol=="operador"){
                    $item->nombre_rol=null;
                    return $item;
                }})->values(); 
            return $return;

       }

    public function headings(): array
    {
        return [
            'NOMBRE',
            'RUT',
            'ESTADO',
            'AREA' 
        ];
    }
}
