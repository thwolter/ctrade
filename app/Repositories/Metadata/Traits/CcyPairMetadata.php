<?php


namespace App\Repositories\Metadata\Traits;


use App\Entities\CcyPair;
use App\Entities\Exchange;
use App\Repositories\DatasourceRepository;
use Illuminate\Support\Facades\Log;

trait CcyPairMetadata
{

    /**
     * Create and persist a new currency pair and assign a datasource.
     *
     * @param array $item
     * @return void
     */
    public function create($item)
    {
        if ($this->valid($item)) {

            $ccyPair = CcyPair::firstOrCreate([
                'origin' => $this->origin,
                'target' => substr($this->symbol($item), 3,3)
            ]);

            $repo = new DatasourceRepository();
            $datasource = $repo->create([
                'provider' => $this->provider,
                'database' => $this->database,
                'dataset' => $this->symbol($item),
                'exchange' => $this->exchange($item),
                'valid' => (int)$this->valid($item),
                'refreshed_at' => $this->refreshed($item),
                'oldest_date' => $this->oldestPrice($item),
                'newest_date' => $this->newestPrice($item),
            ]);

            $datasource->assign($ccyPair);
        }
    }


    /**
     * Update the datasource for an existing currency pair.
     *
     * @param array $item
     * @return void
     */
    public function update($item)
    {
        $this->datasource($item)->update([
            'valid' => (int)$this->valid($item),
            'refreshed_at' => $this->refreshed($item),
            'oldest_date' => $this->oldestPrice($item),
            'newest_date' => $this->newestPrice($item),
        ]);
    }


    protected function exchange($item)
    {
        $exchange = Exchange::whereCodeOrAlias(parent::exchange($item));
        return ($exchange->count()) ? $exchange->first()->code : null;
    }


    protected function valid($item)
    {
        return true;
    }

}