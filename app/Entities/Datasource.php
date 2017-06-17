<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Exceptions\DatasourceException;
use anlutro\LaravelSettings\Facade as Setting;



class Datasource extends Model
{
    protected $fillable = [
        'valid'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }


    public function database()
    {
        return $this->belongsTo(Database::class);
    }


    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
    

    public function stocks()
    {
        return $this->morphedByMany(Stock::class, 'sourcable')->withTimestamps();
    }


    public function ccyPairs()
    {
        return $this->morphedByMany(CcyPair::class, 'sourcable')->withTimestamps();
    }


    public function assign($instrument)
    {
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        if (! $this->$model->contains($instrument->id)) {
            $this->$model()->attach($instrument->id);
        }

        return $this->save();
    }

    public function make($provider, $database, $dataset)
    {
        $source = new Datasource();
        $source
            ->provider()->associate(Provider::firstOrCreate(['code' => $provider]))
            ->database()->associate(Database::firstOrCreate(['code' => $database]))
            ->dataset()->associate(Dataset::firstOrCreate(['code' => $dataset]))
            ->save();

        return $source;
    }


    public function exist($provider, $database, $dataset)
    {
        return is_null(self::get($provider, $database, $dataset)) ? false : true;
    }


    public function get($provider, $database, $dataset)
    {
        $datasetCol = Dataset::whereCode($dataset)->first();

        if (is_null($datasetCol))
            return null;

        $source = self::where('dataset_id', $datasetCol->id)
            ->where('provider_id', Provider::whereCode($provider)->first()->id)
            ->where('database_id', Database::whereCode($database)->first()->id)
            ->first();

        return is_null($source) ? null : $source;
    }
    
    
    public function withDataset($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        return (count($set)) ? self::where('dataset_id', $set->id)->get() : null;
    }
    
    
    public function withDatasetOrFail($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        if (!count($set))
            throw new DatasourceException("No dataset available for '{$dataset}'");
            
        return self::where('dataset_id', $set->id)->get();
    }

    public function isValid()
    {
        $updated = Setting::get($this->provider.$this->database.'updated');

        return ($this->updated_at->lte(Carbon::parse($updated)) and $this->valid);
    }

    public function whereProvider($provider)
    {
        $collection = Provider::whereCode($provider);
        $id = ($collection->count()) ? $collection->first()->id : null;

        return $this->whereProviderId($id);
    }

    public function whereDatabase($database)
    {
        $collection = Database::whereCode($database);
        $id = ($collection->count()) ? $collection->first()->id : null;

        return $this->whereDatabaseId($id);
    }

    public function whereDataset($dataset)
    {
        $collection = Dataset::whereCode($dataset);
        $id = ($collection->count()) ? $collection->first()->id : null;

        return $this->whereDatasetId($id);
    }

    public function whereProviderAndDatabase($provider, $database)
    {
        $collection = Provider::whereCode($provider);
        $providerId = ($collection->count()) ? $collection->first()->id : null;

        $collection= Database::whereCode($database);
        $databaseId = ($collection->count()) ? $collection->first()->id : null;

        return $this->whereProviderId($providerId)->whereDatabaseId($databaseId);

    }
}
