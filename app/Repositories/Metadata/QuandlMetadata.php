<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 07.05.17
 * Time: 18:05
 */

namespace App\Repositories\Metadata;


use App\Entities\Currency;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Models\Pathway;
use App\Repositories\Quandl\Quandldata;

abstract class QuandlMetadata
{

    protected $client;
    protected $provider = 'Quandl';

    protected $perPage = 100;
    protected $nextPage = 1;
    protected $maxPages = 1;
    protected $totalPages = 2;



    public function __construct()
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }


    abstract public function saveItem($item);


    public function loadDatabase()
    {
        while ($this->nextPage <= $this->totalPages) {
            $items = $this->getItems();
            foreach ($items as $item) {

                $instrument = $this->saveItem($item);

                if (!is_null($instrument))
                {
                    Pathway::make($this->provider, $this->database, $this->symbol($item))
                        ->assign($instrument);
                }
            }

            $this->nextPage++;
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