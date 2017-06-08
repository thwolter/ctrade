<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class KeyfigureType extends Model
{

    protected $fillable = ['code', 'name'];


    public function keyFigures()
    {
        return $this->hasMany(Keyfigure::class);
    }
}
