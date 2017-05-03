<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Wkn extends Model
{
    protected $fillable = [
        'wkn'
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
