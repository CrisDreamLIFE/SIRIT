<?php

namespace App\Exports;

use App\Ot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OtsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ot::all();
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
