<?php

namespace App\Exports\OT;

use App\Ot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NumeroOtExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $globalOperacion;
    public $globalCuerpo;
    function __construct($operacion,$cuerpo)
    {
        $this->globalOperacion = $operacion;
        $this->globalCuerpo = $cuerpo;
    }
    public function collection()
    {
        if($globalOperacion==1)return Ot::find($globalCuerpo);
        if($globalOperacion==2)return Ot::where('id','>=',$globalCuerpo)->get();
        if($globalOperacion==2)return Ot::where('id','<=',$globalCuerpo)->get();
    }

    public function headings(): array
    {
        return [
            'Ot',
            'Ot Perú',
            'Fecha de Recepción',
        ];
    }
}
