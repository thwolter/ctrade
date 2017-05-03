<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
