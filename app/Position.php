<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function portfolio() {
        return $this->belongsTo('App\Portfolio');
    }

    public function stock() {
        return $this->hasOne('App\Stock');
    }


}
