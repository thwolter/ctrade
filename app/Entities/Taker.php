<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Taker extends Model
{
    protected $fillable = ['email'];


    public function scopeUnverified($query)
    {
        return $query->where('verified', 0);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
    }
}
