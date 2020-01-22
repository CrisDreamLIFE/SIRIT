<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function ots()
    {
        return $this->belongsToMany(Ot::class, 'ot_productos');
    }

    public function tipoMaterial()
    {
        return $this->belongsTo(TipoMaterial::class);
    }

    public function subProductos()
    {
        return $this->belongsToMany(SubProducto::class, 'producto_sub_productos');
    }

    public function sesionTrabajos()
    {
        return $this->belongsToMany(SesionTrabajo::class, 'producto_sesion_trabajos');
    }

    public function detalleSesions()
    {
        return $this->belongsToMany(SesionTrabajo::class, 'detalle_sesions');
    }
}
