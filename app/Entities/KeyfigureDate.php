<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class KeyfigureDate extends Model
{
    protected $fillable = ['date'];

    public function keyfigures()
    {
        return $this->hasMany(Keyfigure::class);
    }
}
