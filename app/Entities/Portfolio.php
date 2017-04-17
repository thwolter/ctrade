<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{


    protected $fillable = [
        'name',
        'currency',
        'cash'
    ];

    public function user() {
        return $this->belongsTo('App\Entities\User');
    }

    public function positions() {
        return $this->hasMany('App\Entities\Position');
    }

    public function cash() {
        return $this->cash;
    }

    public function valueAtRisk() {
        //
    }

    public function currency()
    {
        return $this->currency;
    }

    public function total()
    {
        return $this->positions->sum->total() + $this->cash();
    }

}

