<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\DatasourceException;



class Datasource extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'valid',
        'refreshed_at',
        'oldest_date',
        'newest_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'refreshed_at',
        'newest_date',
        'oldest_date'
    ];

    protected $touches = [
        'stocks'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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


    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }


    public function stocks()
    {
        return $this->morphedByMany(Stock::class, 'sourcable')->withTimestamps();
    }


    public function ccyPairs()
    {
        return $this->morphedByMany(CcyPair::class, 'sourcable')->withTimestamps();
    }


    /*
   |--------------------------------------------------------------------------
   | FUNCTIONS
   |--------------------------------------------------------------------------
   */


    public function assign($instrument)
    {
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        if (! $this->$model->contains($instrument->id)) {
            $this->$model()->attach($instrument->id);
        }

        return $this->save();
    }


    public function key()
    {
        return sprintf('%s/%s/%s',
            $this->provider->code, $this->database->code, $this->dataset->code);
    }

    public function cacheKey($name)
    {
        return sprintf('%s/%s/%s:%s',
            $this->provider->code, $this->database->code, $this->dataset->code, $name);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopeValid($query)
    {
        return $query->whereValid(true);
    }

    public function scopeWhereProvider($query, $name)
    {
        return $query->whereHas('provider', function($query) use ($name) {
            $query->whereCode($name);
        });
    }

    public function scopeWhereDatabase($query, $name)
    {
        return $query->whereHas('database', function($query) use ($name) {
            $query->whereCode($name);
        });
    }

    public function scopeWhereDataset($query, $name)
    {
        return $query->whereHas('dataset', function($query) use ($name) {
            $query->whereCode($name);
        });
    }

    public function scopeWhereOrigin($query, $provider, $database)
    {
        return $query->whereProvider($provider)->whereDatabase($database);
    }

    public function scopeWithSet($query, $provider, $database, $dataset)
    {
        return $query->whereProvider($provider)->whereDatabase($database)->whereDataset($dataset);
    }

    public function scopeWhereExchange($query, $exchange)
    {
        return $query->whereHas('exchange', function ($query) use ($exchange) {
            $query->whereCode($exchange);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}