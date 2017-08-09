<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Exceptions\DatasourceException;
use anlutro\LaravelSettings\Facade as Setting;



/**
 * App\Entities\Datasource
 *
 * @property int $id
 * @property int $provider_id
 * @property int $database_id
 * @property int $dataset_id
 * @property bool $valid
 * @property string $checked_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entities\Database $database
 * @property-read \App\Entities\Dataset $dataset
 * @property-read \App\Entities\Provider $provider
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereCheckedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereDatabaseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereDatasetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereProviderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Datasource whereValid($value)
 * @mixin \Eloquent
 */
class Datasource extends Model
{
    protected $fillable = ['valid', 'refreshed_at'];

    protected $dates = ['created_at', 'updated_at', 'refreshed_at'];

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

    //todo: change to use the function from repository
    public function make($provider, $database, $dataset, $attributes = [])
    {
        $source = new Datasource($attributes);
        $source
            ->provider()->associate(Provider::firstOrCreate(['code' => $provider]))
            ->database()->associate(Database::firstOrCreate(['code' => $database]))
            ->dataset()->associate(Dataset::firstOrCreate(['code' => $dataset]))
            ->save();

        return $source;
    }

    //todo: change to use the function from repository
    public function exist($provider, $database, $dataset)
    {
        return is_null(self::get($provider, $database, $dataset)) ? false : true;
    }

    //todo: change to use the function from repository
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

    //todo: change to use the function from repository
    public function withDataset($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        return (count($set)) ? self::where('dataset_id', $set->id)->get() : null;
    }

    //todo: change to use the function from repository
    public function withDatasetOrFail($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();
    
        if (!count($set))
            throw new DatasourceException("No dataset available for '{$dataset}'");
            
        return self::where('dataset_id', $set->id)->get();
    }


    public function key()
    {
        return sprintf('%s/%s/%s',
            $this->provider->code, $this->database->code, $this->dataset->code);
    }

    public function scopeValid($query)
    {
        return $query->whereValid(true);
    }
}
