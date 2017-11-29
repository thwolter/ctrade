<?php


namespace App\Classes\Limits;


class FloorLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->figures->risk() / ($this->limit->value - $this->figures->value());
    }
}