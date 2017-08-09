<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = ['code','name'];

    public function datasources()
    {
        return $this->hasMany(Datasource::class);
    }
}
