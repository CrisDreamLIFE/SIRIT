<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    public function sesionTrabajos()
        {
            return $this->belongsToMany(sesionTrabajo::class, 'proceso_sesion_trabajos');
        }

    public function estacions()
        {
            return $this->belongsToMany(Estacion::class, 'estacion_procesos');
        }
        
    public function detalleSesions()
        {
            return $this->belongsToMany(SesionTrabajo::class, 'detalle_sesions');
        }
}
