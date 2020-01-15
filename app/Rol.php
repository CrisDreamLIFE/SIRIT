<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public function usuarios(){
        return $this->belongsToMany(Usuario::class, 'rol_usuarios');
    }
}
