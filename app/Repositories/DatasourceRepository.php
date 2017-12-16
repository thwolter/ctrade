<?php


namespace App\Repositories;


use App\Contracts\DataServiceInterface;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Exchange;
use App\Entities\Provider;
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

        $datasource = new Datasource(array_only($attributes, [
            'valid',
            'refreshed_at',
            'oldest_date',
            'newest_date'
        ]));

        $datasource
            ->provider()->associate($provider)
            ->database()->associate($database)
            ->dataset()->associate($dataset)
            ->exchange()->associate($exchange)
            ->save();

        return $datasource;
    }


    /**
     * @param $datasources
     * @return array
     */
    public function collectHistories($datasources)
    {
        $prices = [];
        foreach ($datasources as $datasource) {
            $data = app(DataServiceInterface::class, [$datasource]);
            $prices[] = [
                'exchange' => $datasource->exchange->code,
                'history' => $data->history(),
                'datasourceId' => $datasource->id];
        };
        return $prices;
    }
}