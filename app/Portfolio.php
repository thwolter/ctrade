<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{

    use Formatter;

    protected $fillable = [
        'name',
        'currency',
        'cash'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function positions() {
        return $this->hasMany('App\Position');
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

