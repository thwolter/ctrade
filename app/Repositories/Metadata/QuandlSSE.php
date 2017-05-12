<?php


namespace App\Repositories\Metadata;

use App\Entities\Stock;
use App\Models\Pathway;
use App\Repositories\Exceptions\MetadataException;
use Illuminate\Support\Facades\Storage;


class QuandlSSE extends Metadata
{
    protected $provider = 'Quandl';
    protected $database = 'SSE';
    
    protected $required = ['symbol', 'name', 'currency'];
    protected $column = 3; // column representing close price

    protected $client;
    protected $useFile = true;


    public function __construct()
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }

    public function loadDatabase($name)
    {
        $items = $this->getItemsFromFile();
        foreach ($items['datasets'] as $item)
        {
            //Todo: check for security type, for now assume all are stocks
            $stock = Stock::saveWithParameter(
                $this->name($item),
                $this->currency($item),
                $this->sector($item)
            );

            Pathway::make($this->provider, $this->database, $this->symbol($item))
                ->assign($stock);
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
        $json = $this->client->getList($this->database, 1, 30);
        //Storage::put('QuandlSSE.json', $json); // for testing reasons
        
        return json_decode($json, true);
    }

    public function getItemsFromFile()
    {
        return json_decode(Storage::get('QuandlSSE.json'), true);
    }

}

