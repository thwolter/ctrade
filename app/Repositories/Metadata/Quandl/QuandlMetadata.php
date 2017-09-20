<?php

namespace App\Repositories\Metadata\Quandl;

use App\Repositories\Metadata\BaseMetadata;
use Carbon\Carbon;
use Quandl;

abstract class QuandlMetadata extends BaseMetadata
{

    protected $provider = 'Quandl';
    protected $queue = 'quandl';

    protected $maxLagging = 30;

    protected $perPage;
    protected $nextPage = 0;
    protected $totalPages = 2;



    public function getFirstItems()
    {
        $this->nextPage = 0;
        return $this->getNextItems($this->chunk);

    }

    public function getNextItems()
    {
        if (is_null($this->nextPage)) return [];

        $json = $this->client->getList($this->database, $this->nextPage, $this->chunk);
        $array = json_decode($json, true);

        $this->nextPage = array_get($array, 'meta.next_page');
        $this->totalPages = array_get($array, 'meta.total_pages');

        return $array['datasets'];
    }



    public function dataset($item)
    {
        return $this->symbol($item);
    }


    public function refreshed($item)
    {
        return Carbon::parse(array_get($item, 'refreshed_at'));
    }


    public function newestPrice($item)
    {
        return Carbon::parse(array_get($item, 'newest_available_date'));
    }


    public function oldestPrice($item)
    {
        return Carbon::parse(array_get($item, 'oldest_available_date'));
    }


    public function tradable($item)
    {
        return $this->newestPrice($item)->diffInDays(Carbon::now()) <= $this->maxLagging;
    }

    /**
     * Fetch details for a given symbol from the provider's database.
     *
     * @param $symbol
     * @return mixed
     */
    public function getSymbol($symbol)
    {
        $item = $this->client->getSymbol($this->database . '/' . $symbol);
        return array_get(json_decode($item, true), 'dataset');
    }

}