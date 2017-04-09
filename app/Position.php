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
        return $this->belongsTo('App\Portfolio');
    }

    public function type() {
        return get_class($this->positionable);
    }

    public function name() {
        return $this->positionable->name();
    }

    public function quantity() {
        return 100; //fake value to be calculated from transaction class
    }

    public function value() {
        return $this->positionable->price();
    }

    public function currency() {
        return $this->positionable->currency();
    }

    public function total() {
        return 300; //fake value
    }
}
