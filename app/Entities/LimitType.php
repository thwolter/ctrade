<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class LimitType extends Model
{

    protected $fillable = ['code', 'name'];


    public function limits()
    {
        return $this->hasMany(Limit::class);
    }
}
