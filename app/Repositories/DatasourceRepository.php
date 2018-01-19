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

    public function find($provider, $database, $dataset)
    {
        if ($datasetCol = Dataset::whereCode($dataset)->first()) {

            return Datasource::where('dataset_id', $datasetCol->id)
                ->where('provider_id', Provider::whereCode($provider)->first()->id)
                ->where('database_id', Database::whereCode($database)->first()->id)
                ->first();
        }

        return null;
    }


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
        $datasource = new Datasource(array_only($attributes, [
            'valid',
            'refreshed_at',
            'oldest_date',
            'newest_date'
        ]));

        $datasource
            ->provider()->associate($this->getProvider($attributes))
            ->database()->associate($this->getDatabase($attributes))
            ->dataset()->associate($this->getDataset($attributes))
            ->exchange()->associate($this->getExchange($attributes))
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

    public function exist($provider, $database, $dataset)
    {
        return !is_null($this->find($provider, $database, $dataset));
    }

    public function withDataset($dataset)
    {
        $set = Dataset::whereCode($dataset)->first();

        return (count($set)) ? Datasource::where('dataset_id', $set->id)->get() : null;
    }


    private function getProvider($attributes)
    {
        return Provider::firstOrCreate(['code' => array_get($attributes, 'provider')]);
    }


    private function getDatabase($attributes)
    {
        return Database::firstOrCreate(['code' => array_get($attributes, 'database')]);
    }


    private function getDataset($attributes)
    {
        return Dataset::firstOrCreate(['code' => array_get($attributes, 'dataset')]);
    }


    private function getExchange($attributes)
    {
        return Exchange::firstOrCreate(['code' => array_get($attributes, 'exchange')]);
    }
}