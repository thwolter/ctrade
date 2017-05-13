<?php

namespace App\Entities;

use Entities\Exceptions\DatasetExceptions;
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

    public function ccyPairs()
    {
        return $this->morphedByMany(CcyPair::class, 'datasetable')->withTimestamps();
    }


    public function providers()
    {
        $ids = null;

        foreach ($this->databases as $database)
        {
            foreach ($database->providers as $provider)
            {
                $ids[$provider->id] = $provider->code;
            }
        }

        return $ids;
    }

    public function hasProviderWithId($id)
    {
        $providers = $this->providers();
        return (is_null($providers)) ? null : array_key_exists($id, $providers);
    }


    public function hasProviderWithCode($code)
    {
        $providers = $this->providers();
        return (is_null($providers)) ? null : in_array($code, $providers);
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
        if (!array_has($codes, 'provider') or
            !array_has($codes, 'database') or
            !array_has($codes, 'dataset'))

            throw new DatasetExceptions(
                "Variable 'codes' must be array with keys 'provider', 'database' and 'dataset'");

        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        $dataset = Dataset::firstOrCreate(['code' => $codes['dataset']]);
        $dataset->$model()->attach($instrument->id);

        $database = Database::firstOrCreate(['code' => $codes['database']]);
        $database->datasets()->attach($dataset->id);

        $provider = Provider::firstOrCreate(['code' => $codes['provider']]);
        $provider->databases()->attach($database->id);

        return $dataset;

    }

}
