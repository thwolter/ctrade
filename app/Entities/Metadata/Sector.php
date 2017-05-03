<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = [
        'sector'
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
