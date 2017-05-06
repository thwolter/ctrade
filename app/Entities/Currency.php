<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $fillable = [
        'iso',
    ];
    
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
