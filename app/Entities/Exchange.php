<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = ['name'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
