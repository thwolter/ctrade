<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $fillable = [
        'iso',
        'name',
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
