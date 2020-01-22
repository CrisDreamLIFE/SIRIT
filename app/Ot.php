<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ot extends Model
{


    public function productos()
        {
            return $this->belongsToMany(Producto::class, 'ot_productos');
        }

    public function categoriaOt()
        {
            return $this->belongsTo(CategoriaOt::class);
        }

    public function otTipo()
        {
            return $this->belongsTo(OtTipo::class);
        }

    public function cliente()
        {
            return $this->belongsTo(Cliente::class);
        }

    public function canalVenta()
        {
            return $this->belongsTo(canalVenta::class);
        }

    public function centroCosto()
        {
            return $this->belongsTo(CentroCosto::class);
        }

    public function usuario()
        {
            return $this->belongsTo(Usuario::class);
        }

    public function sesionTrabajos()
        {
            return $this->belongsToMany(SesionTrabajo::class, 'ot_sesion_trabajos');
        }

    public function detalleSesions()
        {
            return $this->belongsToMany(SesionTrabajo::class, 'detalle_sesions');
        }


    protected $dates = [
    'fecha_recepción', 'fecha_entrega_oc','fecha_real_entrega', 'fecha_despacho'
];


/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    'fecha_inicio' => 'datetime:Y-m-d',
    'hora_inicio' => 'datetime:H:i:s',
    'fecha_termino' => 'datetime:Y-m-d',
    'hora_termino' => 'datetime:H:i:s'
];
}
