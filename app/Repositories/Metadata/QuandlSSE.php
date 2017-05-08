<?php


namespace App\Repositories\Metadata;

use App\Entities\Stock;
use App\Repositories\Exceptions\MetadataException;
use Illuminate\Support\Facades\Storage;


class QuandlSSE extends Metadata
{
    protected $provider = 'Quandl';
    protected $required = ['symbol', 'name', 'currency'];

    protected $client;


    public function loadDatabase($name)
    {
        list($provider, $database) = $this->findOrCreateDatabase($name);

        $items = $this->getItems();
        foreach ($items['datasets'] as $item)
        {
            $path = $this->setPath($item, $provider, $database);

            if ($this->existPath($path)) {

                // update stock
            } else {

                //Todo: check for security type, for now assume all are stocks
                if (! $this->saveStock($item, $path)) { $this->destroyPath($path); }
            }
        }
    }


    public function checkValidity($item)
    {
        foreach ($this->required as $method)
        {
            if (!method_exists($this, $method))
                throw new MetadataException("no method '{$method}' defined");

            $result = $this->$method($item);

            if (is_null($result) or empty($result)) return false;
        }

        return true;

    }

    public function symbol($item)
    {
        return $item['dataset_code'];
    }

    public function name($item)
    {
        $raw_name = strtoupper($item['name']);
        $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);

        return (empty($name)) ? null : title_case($name);
    }

    public function wkn($item)
    {
        $raw_name = strtoupper($item['name']);
        $wkn = trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

        return (empty($wkn)) ? null : $wkn;

    }

    public function isin($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
        return preg_match($re, $raw_name, $matches) ? $matches[1] : null;
    }

    public function currency($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        return preg_match($re, $desc, $matches) ? $matches[1] : null;
    }

    public function sector($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/SECTOR:*\s*([A-Z \-]*)/';

        return preg_match($re, $desc, $matches) ? title_case($matches[1]) : null;
    }

    public function model($item)
    {
        return Stock::class;
    }

    public function getItems()
    {
        $items = json_decode(Storage::get('QuandlSSE.json'), true);
        return $items;

        //$this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        //Storage::put('QuandlSSE.json', $this->client->getList($name, 1, 30));
        //$items = json_decode($this->client->getList($name, 1, 30), true);
    }

}

