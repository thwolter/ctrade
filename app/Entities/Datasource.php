<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Exceptions\DatasourceException;


class Datasource extends Model
{

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
        $datasetCol = Dataset::whereCode($dataset)->first();
        
        if (is_null($datasetCol)) 
            return false;
           
        $source = self::where('dataset_id', $datasetCol->id)
            ->where('provider_id', Provider::whereCode($provider)->first()->id)
            ->where('database_id', Database::whereCode($database)->first()->id)
            ->first();
            
        return ! is_null($source);
    }
    
    
    static public function withDataset($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        if (!count($set))
            throw new DatasourceException("No dataset available for '{$dataset}'");
            
        return self::where('dataset_id', $set->first()->id)->get();
    }
}
