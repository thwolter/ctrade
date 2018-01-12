<?php


namespace App\Repositories;


use App\Entities\Portfolio;


class LimitRepository
{

    private $limits;


    public function getFirstLimit(Portfolio $portfolio)
    {
        return $this->limits($portfolio)->first();
    }


    public function getLimits(Portfolio $portfolio)
    {
        return $this->limits($portfolio);
    }


    private function limits($portfolio)
    {
        if (!$this->limits)
            $this->limits = $portfolio->limits()->orderBy('order')->get();

        return $this->limits;
    }
}