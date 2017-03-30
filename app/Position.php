<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function positionable() {
        return $this->morphTo();
    }

    public function portfolio() {
        return $this->hasOne('App\Portfolio');
    }
}
