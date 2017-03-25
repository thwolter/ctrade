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

    public function position() {
        return $this->hasMany('App\Position');
    }

}

