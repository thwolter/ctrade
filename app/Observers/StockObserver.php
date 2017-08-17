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
        Log::notice(sprintf('Stock %s created', $stock->datasources->first()->dataset->code));
    }


    public function updating(Stock $stock)
    {
        foreach (array_except($stock->getDirty(), 'updated_at') as $key => $value) {
            Log::info(sprintf('%s - %s: %s', $stock->datasources->first()->dataset->code, $key, $value));
        }
    }
}