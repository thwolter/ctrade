<?php


namespace App\Classes\Limits;


class AbsoluteLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->metrics->risk() / $this->limit->value;
    }
}