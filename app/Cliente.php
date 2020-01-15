<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function ots()
        {
            return $this->hasMany(Ot::class);
        }
}
