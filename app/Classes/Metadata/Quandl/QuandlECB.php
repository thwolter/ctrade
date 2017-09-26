<?php


namespace App\Classes\Metadata\Quandl;

use App\Contracts\MetadataInterface;
use App\Entities\Currency;
use App\Classes\Metadata\Traits\CcyPairMetadata;
use Illuminate\Support\Facades\Log;


class QuandlECB extends QuandlMetadata implements MetadataInterface
{
    use CcyPairMetadata;

    public $database = 'ECB';
    protected $origin = 'EUR';

    protected $keys =[
        'symbol'    => ['dataset_code', '/.*/', 0],
    ];


    protected function exchange($item)
    {
        return 'ECB';
    }


    public function getNextItems()
    {
        $items = [];
        foreach (Currency::foreign($this->origin)->get() as $currency)
        {
            $data = $this->client->getSymbol($this->datasetCode($currency));

            if ($data) {
                $items[] = array_get(json_decode($data, true), 'dataset');

            } else {
                Log::warning(sprintf('Could not fetch %s from %s: %s',
                    $this->datasetCode($currency), $this->provider, $this->client->error));
            }
        }

        return $items;
    }


    private function datasetCode($currency): string
    {
        return $this->database . '/' . $this->origin . $currency->code;
    }
}