<?php


namespace App\Classes\Metadata\Traits;


use App\Entities\Currency;
use App\Entities\Exchange;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Facades\Repositories\DatasourceRepository;
use Illuminate\Support\Facades\Log;

trait StockMetadata
{
    private $default = 'N/A';

    protected $legalForm = [
        'Ag' => 'AG',
        'Kgaa' => 'KGaA',
        'Adr' => 'ADR',
        'Se' => 'SE',
        'N.v.' => 'N.V.'
    ];

    public function create($item)
    {
        if ($valid = $this->valid($item)) {

            $instrument = $this->persistStock($this->toArray($item));
            DatasourceRepository::create($this->datasourceArray($item))->assign($instrument);
        }
        return $valid;
    }


    public function update($item)
    {
        $this->datasource($item)->update($this->datasourceArray($item));

        Stock::whereIsin($this->isin($item))->first()
            ->update([
                'name' => $this->name($item),
                'wkn' => $this->wkn($item)
            ]);
    }


    /**
     * Return values which specifying the item's datasource.
     *
     * @param $item
     * @return array
     */
    private function datasourceArray($item)
    {
        return [
            'provider' => $this->provider,
            'database' => $this->database,
            'dataset' => $this->symbol($item),
            'exchange' => $this->exchange($item),
            'valid' => (int)$this->valid($item),
            'refreshed_at' => $this->refreshed($item),
            'oldest_date' => $this->oldestPrice($item),
            'newest_date' => $this->newestPrice($item),
        ];
    }


    public function persistStock($parameter)
    {
        $stock = Stock::firstOrNew(array_only($parameter, ['isin']));
        $stock->wkn = array_get($parameter, 'wkn');

        if (!$stock->checked_at) {
            $stock->name = array_get($parameter, 'name');
        }

        $stock->currency()->associate($this->getCurrency($parameter));
        $stock->sector()->associate($this->getSector($parameter));
        $stock->industry()->associate($this->getIndustry($parameter));

        $stock->save();

        return $stock;
    }


    private function getSector($parameter)
    {
        $sector = array_get($parameter, 'sector');
        return Sector::firstOrCreate(['name' => $sector ?? $this->default]);
    }


    private function getIndustry($parameter)
    {
        $industry = array_get($parameter, 'industry');
        return Industry::firstOrCreate(['name' => $industry ?? $this->default]);
    }


    private function getCurrency($parameter)
    {
        return Currency::firstOrCreate(['code' => $parameter['currency']]);
    }

    protected function model($item)
    {
        return resolve(Stock::class);
    }


    protected function exchange($item)
    {
        $exchange = Exchange::whereCodeOrAlias(parent::exchange($item));
        return ($exchange->count()) ? $exchange->first()->code : null;
    }


    /**
     * @param $item
     * @return array
     */
    protected function toArray($item)
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


    /*
    |--------------------------------------------------------------------------
    | Validity Checks
    |--------------------------------------------------------------------------
    */

    private function valid($item)
    {
        return $this->hasSymbol($item) && $this->hasCurrency($item) &&
            $this->hasIsin($item) && $this->hasExchange($item);
    }


    /**
     * @param $item
     * @return bool
     */
    private function hasSymbol($item)
    {
        if ($this->symbol($item)) return true;

        Log::warning(sprintf('%s skipped (symbol missing)',
            array_get($item, 'dataset_code')
        ));

        return false;
    }

    /**
     * check if currency persists in database
     * @param $item
     *
     * @return bool
     */
    protected function hasCurrency($item)
    {
        if (Currency::whereCode($this->currency($item))->first()) return true;

        Log::warning(sprintf('%s skipped (requires currency %s)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }


    protected function hasIsin($item)
    {
        if ($this->isin($item))
            return true;

        Log::warning(sprintf('%s skipped (isin not defined)', $this->symbol($item)));
        return false;

    }


    protected function hasExchange($item)
    {
        if (parent::exchange($item))
            return true;

        Log::notice(sprintf('%s skipped (exchange [%s] not defined)',
            $this->symbol($item), parent::exchange($item)));

        return false;

    }


    protected function correctLegalForm($name)
    {
        foreach ($this->legalForm as $search => $replace) {
            $name = preg_replace("/(?<=\W)($search)(?=\W|)/", $replace, $name);
        }
        return $name;
    }

}