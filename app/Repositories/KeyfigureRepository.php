<?php

namespace App\Repositories;


use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Term;


class KeyfigureRepository
{

    protected $taxonomy = 'keyfigure';


    /**
     * Find a keyfigure in the database or creates a new one if no available.
     *
     * @param Portfolio $portfolio
     * @param $code
     * @return mixed
     */
    public function getByPortfolio(Portfolio $portfolio, $code)
    {
        return $portfolio->keyfigures()->firstOrCreate([
            'term_id' => $this->getTerm($code)->id
        ]);
    }

    /**
     * Find or create a term item.
     *
     * @param $code
     * @return mixed
     */
    private function getTerm($code)
    {
        return Term::firstOrCreate([
            'code' => $code,
            'taxonomy' => $this->taxonomy
        ]);
    }

    /**
     * Find a keyfigure in the database or creates a new one if no available.
     *
     * @param Asset $asset
     * @param $code
     * @return mixed
     */
    public function getByAsset(Asset $asset, $code)
    {
        return $keyfigure = $asset->portfolio->keyfigures()->firstOrCreate([
            'term_id' => $this->getTerm($code)->id,
            'instrument_id' => $asset->id,
            'instrument_type' => get_class($asset)
        ]);
    }
}
