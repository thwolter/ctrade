<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{

    protected $fillable = ['alias'];

    public function mappable()
    {
        return $this->morphTo();
    }

}
