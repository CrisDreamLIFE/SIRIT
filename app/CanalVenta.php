<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanalVenta extends Model
{
    public function ots()
        {
            return $this->hasMany(Ot::class);
        }
}
