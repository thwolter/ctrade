<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Wkn extends Model
{
    protected $fillable = [
        'wkn'
    ];
    
    public function metadatas()
    {
        return $this->hasMany('App\Entities\Metadata\Metadata');
    }
}
