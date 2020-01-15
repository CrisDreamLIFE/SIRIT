<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    public function ots()
        {
            return $this->hasMany(Ot::class);
        }
}
