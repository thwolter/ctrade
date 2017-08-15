<?php

namespace App\Entities;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{

    use CrudTrait;

    protected $fillable = ['alias'];

    public function mappable()
    {
        return $this->morphTo();
    }

}
