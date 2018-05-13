<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function ruins()
    {
        return $this->hasMany(Ruin::class);
    }
}
