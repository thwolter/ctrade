<?php


namespace App\Classes\Limits;


class AbsoluteLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->risk->portfolioRisk() / $this->limit->value;
    }
}