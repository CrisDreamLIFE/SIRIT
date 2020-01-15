<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuarios');
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_usuarios');
    }

    public function ots()
    {
        return $this->hasMany(Ot::class);
    }

    public function sesionTrabajos()
        {
            return $this->belongsToMany(sesionTrabajo::class, 'sesion_trabajo_usuarios');
        }
}
