<?php


namespace App\Repositories\Metadata;


use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Models\Pathway;
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

            $symbol = $this->database.'/'.$this->origin.$currency;
            $json = $this->client->getSymbol($symbol, ['limit' => 1]);

            $symbol = json_decode($json, true)['dataset']['dataset_code'];

            if ($this->client->error) {
                throw new MetadataException($this->client->error);
            }

            $instrument = $this->saveItem($currency);

            if (!is_null($instrument))
            {
                Pathway::make($this->provider, $this->database, $symbol)
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

    static public function sync()
    {
        $meta = new self();
        $meta->load();
    }
}