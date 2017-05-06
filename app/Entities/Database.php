<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    protected $fillable = [
        'code'
    ];
    
    public function providers()
    {
        return $this->belongsToMany(Provider::class)->withTimestamps();
    }

    public function datasets()
    {
        return $this->belongsToMany(Dataset::class)->withTimestamps();
    }
}
