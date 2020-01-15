<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubProducto extends Model
{
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_sub_productos');
    }

    public function tipoMaterial()
    {
        return $this->belongsTo(TipoMaterial::class);
    }

    public function sesionTrabajos()
        {
            return $this->belongsToMany(SesionTrabajo::class, 'sesion_trabajo_sub_productos');
        }
}
