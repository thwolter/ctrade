<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use App\Repositories\FinancialRepository as Financial;
use App\Repositories\Yahoo\FxData;
use App\Repositories\Yahoo\StockData;

class Stock extends Instrument
{
    protected $fillable = [
        'symbol',
        'currency'
    ];
}
