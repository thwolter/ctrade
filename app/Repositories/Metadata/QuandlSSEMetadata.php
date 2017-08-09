<?php

namespace App\Repositories\Metadata;

use App\Facades\Datasource;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use App\Repositories\Contracts\MetadataInterface;
use App\Repositories\Metadata\Traits\StockMetadata;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSEMetadata extends QuandlMetadata
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
        'description'   => ['description', '/.*/', 0]
    ];

    public function name($item)
    {
        $name = parent::name($item);
        $name = title_case(str_replace('STOCK', '', $name));
        $name = $this->correctLegalForm($name);

        return $name;
    }

}

