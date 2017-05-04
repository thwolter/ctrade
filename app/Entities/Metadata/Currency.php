<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $fillable = [
        'iso',
    ];
    
    public function metadata()
    {
        return $this->hasMany('App\Entities\Metadata\Metadata');
    }
}
