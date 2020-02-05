<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function ots()
        {
            return $this->hasMany(Ot::class);
        }
    public function productos()
        {
            return $this->belongsToMany(Producto::class, 'cliente_productos');
        }
}
