<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Keyfigure extends Model
{
    public function key()
    {
        return $this->hasOne(KeyfigureType::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
