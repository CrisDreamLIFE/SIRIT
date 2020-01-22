<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesionTrabajo extends Model
{
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_sesion_trabajos');
    }

    public function detalleProductos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_sesions');
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }

    public function subProductos()
        {
            return $this->belongsToMany(SubProducto::class, 'sesion_trabajo_sub_productos');
        }

    public function detalleSubProductos()
        {
            return $this->belongsToMany(SubProducto::class, 'detalle_sesions');
        }

    public function ots()
        {
            return $this->belongsToMany(Ot::class, 'ot_sesion_trabajos');
        }

    public function detalleOts()
        {
            return $this->belongsToMany(Ot::class, 'detalle_sesions');
        }
    
    public function detalleProcesos()
        {
            return $this->belongsToMany(Proceso::class, 'detalle_sesions');
        }

    public function procesos()
        {
            return $this->belongsToMany(Proceso::class, 'proceso_sesion_trabajos');
        }

    public function usuarios()
        {
            return $this->belongsToMany(Usuario::class, 'sesion_trabajo_usuarios');
        }

    public function detalleSesions()
        {
            return $this->belongsToMany(DetalleSesion::class, 'detalle_sesions');
        }
}
