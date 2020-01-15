<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    public function sesionTrabajos()
    {
        return $this->hasMany(SesionTrabajo::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function procesos()
        {
            return $this->belongsToMany(Proceso::class, 'estacion_procesos');
        }
}
