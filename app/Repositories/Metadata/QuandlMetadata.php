<?php


namespace App\Repositories\Metadata;

use App\Entities\Currency;
use App\Entities\Dataset;
use App\Repositories\Exceptions\MetadataException;


class QuandlMetadata extends Metadata
{
    
    protected $require = ['Symbol', 'Name', 'Currency'];


    public function __construct() 
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->provider = 'Quandl';
    }


    public function load($database)
    {
        $items = json_decode($this->client->getList($database, 1, 21), true);

        list($provider, $database) = $this->findOrCreateDatabase($database);

        foreach ($items['datasets'] as $item)
        {
            $dataset = Dataset::firstOrCreate(['code' => $this->symbol($item)]);

            $path = [
                'provider' => $provider,
                'database' => $database,
                'dataset'  => $dataset
            ];

            if (! $this->pathExist($path))
            {
                // check for valid stock
                // check for existing entry for stock

                if (! $this->saveStock($item, $path)) $dataset->delete();



            } else {

                // update Stock
            }
        }
    }


    public function saveStock($item, $path)
    {
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

    public function isValid($item)
    {
        foreach ($this->require as $field)
        {
            $method = 'get'.studly_case($field);
            if (!method_exists($this, $method)) $method = $method . 'Id';

            if (!method_exists($this, $method))
                throw new MetadataException("no method '{$method}' defined");

            $id = $this->$method($item);

            return (is_null($id) ? false : true);
        }

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

