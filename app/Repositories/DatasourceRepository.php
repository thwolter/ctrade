<?php


namespace App\Repositories;


use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Exchange;
use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Entities\Provider;
use App\Notifications\LimitChanged;
use App\Repositories\Exceptions\LimitException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatasourceRepository
{

    public function make($provider, $database, $dataset, $attributes = [])
    {
        $datasource = new Datasource($attributes);
        $datasource
            ->provider()->associate(Provider::firstOrCreate(['code' => $provider]))
            ->database()->associate(Database::firstOrCreate(['code' => $database]))
            ->dataset()->associate(Dataset::firstOrCreate(['code' => $dataset]));

        return $datasource;
    }

    public function create($attributes)
    {
        $provider = Provider::firstOrCreate(['code' => array_get($attributes, 'provider')]);
        $database = Database::firstOrCreate(['code' => array_get($attributes, 'database')]);
        $dataset = Dataset::firstOrCreate(['code' => array_get($attributes, 'dataset')]);
        $exchange = Exchange::firstOrCreate(['code' => array_get($attributes, 'exchange')]);

        $datasource = new Datasource(array_only($attributes, ['valid', 'refreshed_at']));

        $datasource
            ->provider()->associate($provider)
            ->database()->associate($database)
            ->dataset()->associate($dataset)
            ->exchange()->associate($exchange)
            ->save();

        return $datasource;
    }


    public function updatedAfter($timestamp)
    {
        return DB::table('datasources')
            ->where('updated_at', '>', $timestamp);
    }

}