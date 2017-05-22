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

    public function hasProvider($id)
    {
        $providers = $this->providers;

        foreach ($providers as $provider)
        {
            if ($provider->id == $id) return true;
        }
        return false;

    }
}
