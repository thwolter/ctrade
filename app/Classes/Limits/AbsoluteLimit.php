<?php


namespace App\Classes\Limits;


class AbsoluteLimit extends AbstractLimit
{

    public function utilisation()
    {
        return $this->figures->risk() / $this->limit->value;
    }
}