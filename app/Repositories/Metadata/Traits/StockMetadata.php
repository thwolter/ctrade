<?php


namespace App\Repositories\Metadata\Traits;


use App\Entities\Currency;
use App\Entities\Exchange;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Facades\Datasource;
use App\Repositories\DatasourceRepository;
use Illuminate\Support\Facades\Log;

trait StockMetadata
{

    protected $legalForm = [
        'Ag' => 'AG',
        'Kgaa' => 'KGaA',
        'Adr' => 'ADR',
        'Se' => 'SE',
        'N.v.' => 'N.V.'
    ];

    public function create($item)
    {
        if ($this->valid($item)) {

            $instrument = $this->persistStock($this->toArray($item));

            $repo = new DatasourceRepository();
            $datasource = $repo->create([
                'provider' => $this->provider,
                'database' => $this->database,
                'dataset' => $this->symbol($item),
                'exchange' => $this->exchange($item),
                'valid' => (int)$this->valid($item),
                'refreshed_at' => $this->refreshed($item)
            ]);

            $datasource->assign($instrument);

            return true;
        }
    }


    public function update($item)
    {
        $this->datasource($item)->update([
            'valid' => (int)$this->valid($item),
            'refreshed_at' => $this->refreshed($item)
        ]);

        $stock = Stock::whereIsin($this->isin($item))->first();
        $stock->propsedName = $this->name($item);
        $stock->wkn = $this->wkn($item);

        if (!$stock->checked_at) {
            $stock->name = $stock->proposed_name;
        }

       $stock->update();
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


    protected function valid($item)
    {
        return $this->isIdentifiable($item) && $this->hasCurrency($item) &&
            $this->hasIsin($item) && $this->hasExchange($item);
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

    /**
     * @param $item
     * @return bool
     */
    protected function isIdentifiable($item)
    {
        if (!is_null($this->symbol($item)) || !is_null($this->name($item)) ||
            !is_null($this->currency($item))) return true;

        Log::notice(sprintf('%s skipped (name or currency missing)',
            $this->symbol($item), $this->currency($item)
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
        if (Currency::whereCode($this->currency($item))->first())
            return true;

        Log::notice(sprintf('%s skipped (requires currency %s)',
            $this->symbol($item), $this->currency($item)
        ));

        return false;
    }


    protected function hasIsin($item)
    {
        if ($this->isin($item)) {
            return true;
        } else {
            Log::notice(sprintf('%s skipped (isin not defined)', $this->symbol($item)));
            return false;
        }
    }


    protected function hasExchange($item)
    {
        $exchange = $this->exchange($item);

        if ($exchange) {
            return true;

        } else {
            Log::notice(sprintf('%s skipped (exchange [%s] not defined)',
                $this->symbol($item), parent::exchange($item)));
            return false;
        }
    }


    public function persistStock($parameter)
    {
        $stock = Stock::firstOrNew(array_only($parameter, ['isin']));
        $stock->wkn = array_get($parameter, 'wkn');


        if (!$stock->checked_at) {
            $stock->name = array_get($parameter, 'name');
        }

        $stock->currency()->associate(Currency::firstOrCreate(['code' => $parameter['currency']]));

        if (!is_null(array_get($parameter, 'sector')))
            $stock->sector()->associate(Sector::firstOrCreate(['name' => $parameter['sector']]));

        if (!is_null(array_get($parameter, 'industry')))
            $stock->industry()->associate(Industry::firstOrCreate(['name' => $parameter['industry']]));

        $stock->save();
        return $stock;
    }


    protected function correctLegalForm($name)
    {
        foreach ($this->legalForm as $search => $replace) {
            $name = preg_replace("/(?<=\W)($search)(?=\W|)/", $replace, $name);
        }
        return $name;
    }
}