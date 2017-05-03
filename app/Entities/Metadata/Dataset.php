<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
