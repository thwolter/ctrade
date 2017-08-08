<?php

namespace App\Repositories\Metadata;

use App\Facades\Datasource;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use App\Repositories\Contracts\MetadataInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSEMetadata extends QuandlMetadata
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


    public function valid($item)
    {
        return $this->isIdentifiable($item) && $this->hasCurrency($item);
    }


    public function create($item)
    {
        if ($this->valid($item)) {

            $instrument = $this->model($item)->saveWithParameter($this->toArray($item));

            Datasource::make($this->provider, $this->database, $this->symbol($item), [
                'valid' => (int)$this->valid($item),
                'refreshed_at' => $this->refreshed($item)->toDateTimeString()
            ])->assign($instrument);
        }
    }
    
    
    public function update($item)
    {
       $this->datasource($item)->update([
           'valid' => (int)$this->valid($item),
           'refreshed_at' => $this->refreshed($item)->toDateTimeString()
       ]);

       $this->model($item)->update([
           'wkn' => $this->wkn($item),
           'isin' => $this->isin($item),
           'name' => $this->name($item)
       ]);
    }

    

    public function model($item)
    {
        return resolve(Stock::class);
    }

    public function exchange($item)
    {
        return 'Börse Stuttgart';
    }


    /**
     * @param $item
     * @return array
     */
    private function toArray($item)
    {
        $parameter = [
            'name' => $this->name($item),
            'currency' => $this->currency($item),
            'wkn' => $this->wkn($item),
            'isin' => $this->isin($item),
            'sector' => $this->sector($item),
            'industry' => $this->industry($item),
            'exchange' => $this->exchange($item)
        ];
        return $parameter;
    }

    /**
     * @param $item
     * @return bool
     */
    private function isIdentifiable($item)
    {
        if (!is_null($this->symbol($item)) || !is_null($this->name($item)) ||
            !is_null($this->currency($item))) return true;

        Log::notice(sprintf('%s skipped (name or currency missing)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }


    /**
     * check if currency persists in database
     * @param $item
     *
     * @return bool
     */
    private function hasCurrency($item)
    {
        if (Currency::whereCode($this->currency($item))->first())
            return true;

        Log::notice(sprintf('%s skipped (requires currency %s)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }
}

