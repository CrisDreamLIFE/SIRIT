<?php

namespace App\Exports\ESTACION;

use App\Estacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TodasExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        $estacionCompleto = Estacion::join("areas","estacions.area_id","=","areas.id")
                        ->select('estacions.codigo','estacions.descripcion','areas.nombre_area')
                        ->get();
            
        

            return $estacionCompleto;

       }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESCRIPCION',
            'AREA', 
        ];
    }
}
