<?php


namespace App\Classes\Limits;


class FloorLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->metrics->risk() / ($this->limit->value - $this->metrics->value());
    }
}