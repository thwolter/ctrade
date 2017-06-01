<?php


namespace App\Repositories\Metadata;


use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Entities\Datasource;
use App\Repositories\Exceptions\MetadataException;


class QuandlECB extends QuandlMetadata
{

    protected $database = 'ECB';
    protected $origin = 'EUR';
    protected $baseCcy = ['USD', 'CHF'];


    public function load()
    {
        $dbCcy = array_column(Currency::all()->toArray(), 'code');
        $currencies = array_unique(array_merge($this->baseCcy, $dbCcy));

        $currencies = array_where($currencies, function($value) {return $value != 'EUR';});
        foreach ($currencies as $currency) {

            $datasetCode = $this->database.'/'.$this->origin.$currency;
            $json = $this->client->getSymbol($datasetCode, ['limit' => 1]);

            // simple check if symbol is an available currency-pair
            $symbol = json_decode($json, true)['dataset']['dataset_code'];

            if ($this->client->error) {
                throw new MetadataException("{$this->client->error} for symbol '{$symbol}'");
            }

            $instrument = $this->saveItem($currency);

            if (!is_null($instrument))
            {
                Datasource::make($this->provider, $this->database, $symbol)
                    ->assign($instrument);
            }
        }
    }

    public function saveItem($item)
    {
        $currency = CcyPair::firstOrCreate([
            'origin' => $this->origin,
            'target' => $item,
        ]);

        return $currency;
    }
    
    
    public function updateItem($item)
    {
        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name

        return false;

        //return true if updated
    }

    static public function sync()
    {
        $meta = new self();
        $meta->load();
    }
}