<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'positionable_type',
        'positionable_id'
    ];

    public function positionable() {
        return $this->morphTo();
    }

    public function portfolio() {
        return $this->hasOne('App\Portfolio');
    }
}
