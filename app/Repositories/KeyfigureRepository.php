<?php

namespace App\Repositories;


use App\Entities\Portfolio;
use App\Entities\Term;
use App\Services\MetricServices\PortfolioMetricService;


class KeyfigureRepository
{

    protected $taxonomy = 'keyfigure';


    public function getForPortfolio(Portfolio $portfolio, $code)
    {
        $term = Term::firstOrCreate([
            'code' => $code,
            'taxonomy' => $this->taxonomy
        ]);

        return $portfolio->keyfigures()->firstOrCreate(['term_id' => $term->id]);
    }


    public function getComponentVaR(Portfolio $portfolio, $code, $instrument)
    {
        $term = Term::firstOrCreate([
            'code' => $code,
            'taxonomy' => $this->taxonomy
        ]);

        return $portfolio->keyFigures()->firstOrCreate([
            'term_id' => $term->id,
            'instrument_type' => get_class($instrument),
            'instrument_id' => $instrument->id
        ]);
    }
}
