<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nave extends Model
{
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
