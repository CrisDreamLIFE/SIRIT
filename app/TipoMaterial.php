<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMaterial extends Model
{
    public function productos()
        {
            return $this->hasMany(Producto::class);
        }

    public function subProductos()
        {
            return $this->hasMany(SubProducto::class);
        }
}
