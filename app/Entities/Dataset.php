<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $fillable = [
        'code'
    ];

    public function databases()
    {
        return $this->belongsToMany(Database::class)->withTimestamps();
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class)->withTimestamps();
    }

    public function providers()
    {
        $ids = null;

        foreach ($this->databases as $database)
        {
            foreach ($database->providers as $provider)
            {
                $ids[$provider->id] = $provider->name;
            }
        }

        return $ids;
    }

    public function hasProvider($id)
    {
        $providers = $this->providers();

        return (is_null($providers)) ? null : array_key_exists($id, $this->providers());
    }

    public function hasDatabase($id)
    {
        foreach ($this->databases as $database)
        {
            if ($database->id == $id) return true;
        }

        return false;
    }

    public function sourceToProvider($id)
    {

    }
}
