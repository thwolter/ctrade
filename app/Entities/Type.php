<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Type extends Model
{

    protected $fillable = ['code', 'name'];


    public function history()
    {
        return $this->hasMany(History::class);
    }
}
