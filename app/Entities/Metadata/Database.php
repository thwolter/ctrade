<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    protected $fillable = [
        'code'
    ];
    
    public function metadata()
    {
        return $this->belongsTo('App\Entities\Metadata\Metadata');
    }
}
