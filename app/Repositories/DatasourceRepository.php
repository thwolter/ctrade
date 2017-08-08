<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Entities\Provider;
use App\Notifications\LimitChanged;
use App\Repositories\Exceptions\LimitException;
use Carbon\Carbon;

class DatasourceRepository
{


    public function __construct()
    {

    }


    public function whereProvider($provider)
    {
        return Datasource::whereHas('provider', function($query) use($provider) {
            $query->whereCode($provider);
        });
    }


    public function whereDatabase($provider)
    {
        return Datasource::whereHas('database', function($query) use($database) {
            $query->whereCode($database);
        });
    }


    public function whereDataset($dataset)
    {
        return Datasource::whereHas('dataset', function($query) use($dataset) {
            $query->whereCode($dataset);
        });
    }


    public function whereOrigin($provider, $database)
    {
        $providerId = Provider::whereCode($provider)->first()->id;
        $databaseId = Database::whereCode($database)->first()->id;

        return Datasource::whereProviderId($providerId)->whereDatabaseId($databaseId);

    }


    public function make($provider, $database, $dataset, $attributes = [])
    {
        $datasource = new Datasource($attributes);
        $datasource
            ->provider()->associate(Provider::firstOrCreate(['code' => $provider]))
            ->database()->associate(Database::firstOrCreate(['code' => $database]))
            ->dataset()->associate(Dataset::firstOrCreate(['code' => $dataset]))
            ->save();

        return $datasource;
    }

}