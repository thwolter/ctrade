<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function databases()
    {
        return $this->belongsToMany(Database::class)->withTimestamps();
    }

}
