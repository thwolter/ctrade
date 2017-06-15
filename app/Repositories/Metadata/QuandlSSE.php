<?php

namespace App\Repositories\Metadata;

use App\Entities\Datasource;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSE extends QuandlMetadata
{
    public $database = 'SSE';
    
    protected $keys =[
        'isin'      => ['name', '/(?i)(?<=ISIN )(\w{1,})/', 0],
        'wkn'       => ['name', '/(?i)(?<=WKN )(\w{1,})/', 0],
        'currency'  => ['description', '/(?i)(?<=CURRENCY:)(\w{1,})/', 0],
        'name'      => ['name', '/.+?(?= WKN)/', 0],
        'symbol'    => ['dataset_code', '/.*/', 0],
        'sector'    => ['description', '/(?i)(?<=Sector: )(.*(?= -))/', 0],
        'industry'  => ['description', '/(?i)(?<=Sector: ).*(?<=-)(.*)/', 1],
        'description'   => ['description', '/.*/', 0]
    ];


    public function isValid($item)
    {
        return $this->checkIdentifiable($item) and
            $this->checkFresh($item) and $this->checkCurrency($item);
    }


    public function saveItem($item)
    {
        //Todo: check for security type, for now assume all are stocks

        if (!$this->isValid($item)) return null;

        return Stock::saveWithParameter($this->toArray($item));
    }
    
    
    public function updateItem($item)
    {
        if ($this->isValid($item)) {
            return $this->persistValid(true, $item);
        }
        else {
            return $this->persistValid(false, $item);
        }
    }


    public function latestPrice($item)
    {
        return new Carbon($item['newest_available_date']);
    }
    
    
    public function refreshed($item)
    {
        return new Carbon($item['refreshed_at']);
    }


    public function model($item)
    {
        return Stock::class;
    }


    public function getItemsFromFile()
    {
        return json_decode(Storage::get('QuandlSSE.json'), true)['datasets'];
    }


    
    /**
     * @param $item
     * @return array
     */
    private function toArray($item): array
    {
        $parameter = [
            'name' => $this->name($item),
            'currency' => $this->currency($item),
            'wkn' => $this->wkn($item),
            'isin' => $this->isin($item),
            'sector' => $this->sector($item),
            'industry' => $this->industry($item)
        ];
        return $parameter;
    }

    /**
     * @param $item
     * @return bool
     */
    private function checkIdentifiable($item): bool
    {
        if (!is_null($this->symbol($item)) || !is_null($this->name($item)) ||
            !is_null($this->currency($item))) return true;

        Log::notice(sprintf('%s skipped (name or currency missing)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }

    /**
     * check if last available date corresponds to refreshed data
     *
     * @param $item
     * @return bool
     */
    private function checkFresh($item)
    {
        if ($this->latestPrice($item)->diffInDays($this->refreshed($item)) == 0) return true;

        Log::notice(sprintf('%s skipped (last price %s)',
            $this->symbol($item), $this->latestPrice($item)
        ));

        return false;
    }

    /**
     * check if currency persists in database
     * @param $item
     *
     * @return bool
     */
    private function checkCurrency($item)
    {
        if (!is_null(Currency::whereCode($this->currency($item))->first())) return true;

        Log::notice(sprintf('%s skipped (requires currency %s)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }

    /**
     * @param $valid
     * @param $item
     *
     * @return bool
     */
    private function persistValid($valid, $item)
    {
        Datasource::get($this->provider, $this->database, $this->symbol($item))
            ->update(['valid' => $valid]);

        return $valid;
    }

}

