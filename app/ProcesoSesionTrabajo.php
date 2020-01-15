<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesoSesionTrabajo extends Model
{
    protected $dates = [
    'fecha_inicio', 'fecha_termino','hora_inicio', 'hora_termino'
];


/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    'fecha_inicio' => 'datetime:Y-m-d',
    'hora_inicio' => 'datetime:H:i:s',
    'fecha_termino' => 'datetime:Y-m-d',
    'hora_termino' => 'datetime:H:i:s'
];
}
