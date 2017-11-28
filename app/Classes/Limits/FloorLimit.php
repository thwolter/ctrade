<?php


namespace App\Classes\Limits;


class FloorLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->risk->portfolioRisk() / $this->limit->value;
    }
}