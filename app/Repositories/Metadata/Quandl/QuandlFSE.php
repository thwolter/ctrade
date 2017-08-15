<?php

namespace App\Repositories\Metadata\Quandl;

use App\Repositories\Contracts\MetadataInterface;
use App\Repositories\Metadata\Traits\StockMetadata;


class QuandlFSE extends QuandlMetadata implements MetadataInterface
{
    use StockMetadata;

    public $database = 'FSE';
    public $exchange = 'FSE';
    
    protected $keys =[
        'isin'      => ['description', '/(?:ISIN:\s([[:alnum:]]*))/', 1],
        'name'      => ['name', '/(.*)(\([^()]*\))/', 1],
        'exchange'  => ['description', '/Trading System: (\w*)/', 1],
        'description'   => ['description', '/.*/', 0]
    ];

    public function wkn($item)
    {
        return null;
    }

    public function currency($item)
    {
        return 'EUR';
    }

    public function symbol($item)
    {
        return array_get($item, 'dataset_code');
    }

    public function industry($item)
    {
        return null;
    }

    public function sector($item)
    {
        return null;
    }

    public function name($item)
    {
        $name = parent::name($item);
        return $this->correctLegalForm(title_case($name));
    }
}

