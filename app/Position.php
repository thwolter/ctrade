<?php

namespace App;

use App\Library\FxData;
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

        $portfolio_currency = $this->portfolio->currency;

        $fxRate = 1;
        if ($portfolio_currency != $this->currency()) {

            $fx = new FxData($this->currency().$this->portfolio->currency);
            $fxRate = $fx->Rate;
        }
        return $this->value() * $fxRate; //fake value
    }


}
