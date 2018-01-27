<?php

namespace App\Repositories;


use App\Entities\Portfolio;
use App\Entities\Term;


class KeyfigureRepository
{

    protected $taxonomy = 'keyfigure';


    public function find(Portfolio $portfolio, $code)
    {
        return $portfolio->keyfigures()
            ->firstOrCreate(['term_id' => $this->getTerm($code)->id]);
    }


    private function getTerm($code)
    {
        return Term::firstOrCreate([
            'code' => $code,
            'taxonomy' => $this->taxonomy
        ]);
    }

    public function getForPortfolio(Portfolio $portfolio, $code)
    {
        return $this->find($portfolio, $code);
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
