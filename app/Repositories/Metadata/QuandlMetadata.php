<?php

namespace App\Repositories\Metadata;


use App\Models\Pathway;
use App\Repositories\Exceptions\MetadataException;

abstract class QuandlMetadata
{

    protected $client;
    protected $provider = 'Quandl';
    protected $database;

    protected $perPage = 100;
    protected $nextPage = 0;
    protected $maxPages = INF;
    protected $totalPages = 2;



    public function __construct()
    {
        //Todo: check for test environment and limit data reading
        if (env('APP_ENV') == 'testing') {
            $this->setTestingParameters();
        }

        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }


    private function setTestingParameters()
    {
        $this->maxPages = 1;
        $this->perPage = 5;
    }

    abstract public function saveItem($item);


    public function load()
    {
        if (!isset($this->database)) {
            throw new MetadataException("variable 'database' must be set");
        }

        while ($this->nextPage++ <= min($this->totalPages, $this->maxPages)) {
            $items = $this->getItems();
            foreach ($items as $item) {

                $instrument = $this->saveItem($item);

                if (!is_null($instrument))
                {
                    Pathway::make($this->provider, $this->database, $this->symbol($item))
                        ->assign($instrument);
                }
            }
        }
    }


    public function getItems()
    {
        $json = $this->client->getList($this->database, $this->nextPage, $this->perPage);
        //Storage::put('QuandlSSE.json', $json); // for testing reasons

        $array = json_decode($json, true);

        $this->nextPage = array_get($array, 'meta.next_page');
        $this->totalPages = array_get($array, 'meta.total_pages');

        return $array['datasets'];
    }
}