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

    static public function make($provider, $database, $dataset)
    {
        $source = new Datasource();
        $source
            ->provider()->associate(Provider::firstOrCreate(['code' => $provider]))
            ->database()->associate(Database::firstOrCreate(['code' => $database]))
            ->dataset()->associate(Dataset::firstOrCreate(['code' => $dataset]))
            ->save();

        return $source;
    }


    static public function exist($provider, $database, $dataset)
    {
        return is_null(self::get($provider, $database, $dataset)) ? false : true;
    }


    static public function get($provider, $database, $dataset)
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
    
    
    static public function withDataset($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        return (count($set)) ? self::where('dataset_id', $set->id)->get() : null;
    }
    
    
    static public function withDatasetOrFail($dataset)
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
}
