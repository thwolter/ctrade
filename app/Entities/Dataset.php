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
        return $this->morphedByMany(Stock::class, 'datasetable')->withTimestamps();
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

    static public function saveWithPath($instrument, Array $codes)
    {
        Currency::create(['code' => $stock->currency()])
            ->stocks()->save($stock);

        Sector::create(['name' => $stock->sector()])
            ->stocks()->save($stock);

        $dataset = Dataset::firstOrCreate(['name' => $pathway['dataset']]);
        $dataset->stocks()->attach($stock->id);

        $database = Database::firstOrCreate(['code' => $pathway['database']]);
        $database->datasets()->attach($dataset->id);

        $provider = Provider::firstOrCreate(['name' => $pathway['provider']]);
        $provider->databases()->attach($database->id);

    }

}
