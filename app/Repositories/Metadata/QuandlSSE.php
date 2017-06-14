<?php

namespace App\Repositories\Metadata;

use App\Entities\Datasource;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSE extends QuandlMetadata
{
    public $database = 'SSE';


    public function isValid($item)
    {
        return $this->checkIdentifiable($item) and
            $this->checkFresh($item) and $this->checkCurrency($item);
    }


    public function saveItem($item)
    {
        //Todo: check for security type, for now assume all are stocks

        if (!$this->isValid($item)) return null;

        return Stock::saveWithParameter($this->toArray($item));
    }
    
    
    public function updateItem($item)
    {
        if ($this->isValid($item)) {

            Datasource::get($this->provider, $this->database, $this->symbol($item))
                ->update(['valid' => true]);

            return true;
        }
        
        else {
            
            Datasource::get($this->provider, $this->database, $this->symbol($item))
                ->update(['valid' => false]);

            return false;
        }
    }


    public function symbol($item)
    {
        return $item['dataset_code'];
    }


    public function description($item)
    {
        return $item['description'];
    }


    public function name($item)
    {
        $raw_name = strtoupper($item['name']);
        $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);

        return $this->check('name', $name, $item);
    }

    
    public function wkn($item)
    {
        $raw_name = strtoupper($item['name']);
        $wkn = @trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

        return $this->check('wkn', $wkn, $item);
    }

    public function isin($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
        $match = preg_match($re, $raw_name, $matches);

        if ($match) return $matches[1];
        return $this->unableLog('ISIN', $item);
    }

    public function currency($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        $match = preg_match($re, $desc, $matches);
        
        if ($match) return $matches[1];
        return $this->unableLog('currency', $item);
    }


    public function sectorAndIndustry($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/SECTOR:*\s*([A-Z \/ \& \-\(\)]*)/';

        return (preg_match($re, $desc, $matches)) ? $matches[1] : null;
    }


    public function sector($item)
    {
        $sector = title_case(trim(explode('-', $this->sectorAndIndustry($item))[0]));

        return $this->check('sector', $sector, $item);
    }


    public function industry($item)
    {
        $split = explode(' - ', $this->sectorAndIndustry($item));
        
        if (count($split) == 2) return title_case(trim($split[1]));
        return $this->unableLog('industy', $item);
    }


    public function latestPrice($item)
    {
        return new Carbon($item['newest_available_date']);
    }
    
    
    public function refreshed($item)
    {
        return new Carbon($item['refreshed_at']);
    }


    public function model($item)
    {
        return Stock::class;
    }


    public function getItemsFromFile()
    {
        return json_decode(Storage::get('QuandlSSE.json'), true)['datasets'];
    }



    private function unableLog($param, $item)
    {
        Log::notice(sprintf("'%s' missing for %s -- %s",
            $param, $this->symbol($item), $this->description($item)
        ));

        return null;
    }

    /**
     * @param string $string
     * @param string $value
     * @param $item
     * @return null|string
     */
    private function check($string, $value, $item)
    {
        if (!empty($value)) return $value;

        $this->unableLog($string, $item);
        return null;
    }

    /**
     * @param $item
     * @return array
     */
    private function toArray($item): array
    {
        $parameter = [
            'name' => $this->name($item),
            'currency' => $this->currency($item),
            'wkn' => $this->wkn($item),
            'isin' => $this->isin($item),
            'sector' => $this->sector($item),
            'industry' => $this->industry($item)
        ];
        return $parameter;
    }

    /**
     * @param $item
     * @return bool
     */
    private function checkIdentifiable($item): bool
    {
        if (!is_null($this->symbol($item)) || !is_null($this->name($item)) ||
            !is_null($this->currency($item))) return true;

        Log::notice(sprintf('%s skipped (name or currency missing)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }

    /**
     * check if last available date corresponds to refreshed data
     *
     * @param $item
     * @return bool
     */
    private function checkFresh($item)
    {
        if ($this->latestPrice($item)->diffInDays($this->refreshed($item)) == 0) return true;

        Log::notice(sprintf('%s skipped (last price %s)',
            $this->symbol($item), $this->latestPrice($item)
        ));

        return false;
    }

    /**
     * check if currency persists in database
     * @param $item
     *
     * @return bool
     */
    private function checkCurrency($item)
    {
        if (!is_null(Currency::whereCode($this->currency($item))->first())) return true;

        Log::notice(sprintf('%s skipped (requires currency %s)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }

}

