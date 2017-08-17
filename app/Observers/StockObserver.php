<?php


namespace App\Observers;


use App\Entities\Datasource;
use App\Entities\Stock;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class StockObserver
{

    public function created(Stock $stock)
    {
        $name = sprintf('%s (%s)', $stock->name, $stock->isin);
        Log::notice(sprintf('Create stock %s.', $name));
    }


    public function updating(Stock $stock)
    {
        $code = $stock->datasources->first()->dataset->code;
        foreach (array_except($stock->getDirty(), 'updated_at') as $key => $value) {
            Log::info(sprintf('%s - %s: %s', $code, $key, $value));
        }
    }
}