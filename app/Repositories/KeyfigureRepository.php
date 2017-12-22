<?php

namespace App\Repositories;


use App\Entities\Portfolio;
use App\Entities\Term;


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

}
