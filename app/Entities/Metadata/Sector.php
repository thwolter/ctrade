<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = [
        'sector'
    ];
    
    public function metadatas()
    {
        return $this->hasMany('App\Entities\Metadata\Metadata');
    }
}
