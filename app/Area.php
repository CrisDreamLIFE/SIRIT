<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'area_usuarios');
    }

    public function nave()
    {
        return $this->belongsTo(Nave::class);
    }

    public function estacions()
    {
        return $this->hasMany(Estacion::class);
    }
}
