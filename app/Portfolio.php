<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'name',
        'currency'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function positions() {
        return $this->hasMany('App\Position');
    }

    public function cash() {
        return 3000; //fake value;
    }

    public function valueAtRisk() {
        //
    }

    public function total() {
        $total = 0;
        foreach ($this->positions as $position) {
            $total = $total + $position->total();
        }
        return $total;
    }


}

