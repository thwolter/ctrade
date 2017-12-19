<?php

namespace App\Classes\Metadata\Quandl;

use App\Contracts\MetadataInterface;
use App\Classes\Metadata\Traits\StockMetadata;


class QuandlSSE extends QuandlMetadata implements MetadataInterface
{
    use StockMetadata;

    public $database = 'SSE';
    public $exchange = 'SSE';
    
    protected $keys =[
        'isin'      => ['name', '/(?i)(?<=ISIN )(\w{1,})/', 0],
        'wkn'       => ['name', '/(?i)(?<=WKN )(\w{1,})/', 0],
        'currency'  => ['description', '/(?i)(?<=CURRENCY:)(\w{1,})/', 0],
        'name'  => ['name', '/.+?(?= WKN)/', 0],
        'symbol'    => ['dataset_code', '/.*/', 0],
        'sector'    => ['description', '/(?i)(?<=Sector: )(.*(?= -))/', 0],
        'industry'  => ['description', '/(?i)(?<=Sector: ).*(?<=-)(.*)/', 1],
        'exchange'  => ['name', '/- ([\w|\s]*)$/', 1],
        'exchange2'  => ['description', '/(Boerse )(\w*)/', 2],
        'description'   => ['description', '/.*/', 0]
    ];

    public $columns = [
        'Date'   => 'Date',
        'High'   => 'High',
        'Low'    => 'Low',
        'Close'  => 'Last',
        'Volume' => 'Volume',
    ];

    public function name($item)
    {
        $name = parent::name($item);
        $name = trim(title_case(str_replace('STOCK', '', $name)));
        $name = $this->correctLegalForm($name);

        return $name;
    }

    public function exchange($item)
    {
        $exchange = parent::exchange($item);
        return ($exchange) ? $exchange : parent::exchange2($item);
    }
}

