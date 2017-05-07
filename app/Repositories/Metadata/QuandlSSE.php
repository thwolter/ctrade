<?php


namespace App\Repositories\Metadata;

use App\Entities\Currency;
use App\Entities\Dataset;
use App\Repositories\Exceptions\MetadataException;


class QuandlSSE extends Metadata
{
    protected $provider = 'Quandl';

    protected $required = ['symbol', 'name', 'currency'];


    public function __construct() 
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }


    public function loadDatabase($name)
    {
        list($provider, $database) = $this->findOrCreateDatabase($name);

        $items = json_decode($this->client->getList($name, 1, 30), true);

        foreach ($items['datasets'] as $item)
        {
            $dataset = Dataset::firstOrCreate(['code' => $this->symbol($item)]);

            $path = [
                'provider' => $provider,
                'database' => $database,
                'dataset'  => $dataset
            ];

            if ($this->pathExist($path)) {

                // update stock
            } else {

                if (! $this->saveStock($item, $path)) {$dataset->delete();}

            }
        }
    }


    public function saveStock($item, $path)
    {
        if (!$this->validStock($item)) return false;

        $stock = Currency::firstOrCreate(['code' => $this->currency($item)])
            ->stocks()->create([
                'name' => $this->name($item),
                'wkn' => $this->wkn($item),
                'isin' => $this->isin($item)
        ]);

        $this->assignSectorToStock($this->sector($item), $stock);
        $this->assignDatabaseToStock($path['database'], $path['dataset'], $stock);

        return true;
    }


    public function validStock($item)
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


}

