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





    /**
     * Return the Portfolio's absoluteReturn over a specified period.
     *
     * @param Portfolio $portfolio
     * @param null $count
     * @param bool $percent
     * @return Percent|Price
     */
    public function absoluteReturn(Portfolio $portfolio, $count = null, $percent = false)
    {
        $values = KeyfigureRepository::getByPortfolio($portfolio, 'value')->timeseries()
            ->count(1 + ($count || $this->getPeriod($portfolio)))->get();

        if (count($values) != $count) return null;

        return $percent
            ? new Percent(key($values), $this->deltaPercent($values))
            : new Price(key($values), $this->deltaAbsolute($values), $portfolio->currency->code);
    }


    /**
     * Return the percentage delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaPercent($values)
    {
        return $this->deltaAbsolute($values) / array_first($values);
    }

    /**
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaAbsolute($values)
    {
        return array_last($values) - array_first($values);
    }

}
