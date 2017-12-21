<?php

namespace App\Classes;


use Carbon\Carbon;
use Closure;

class Price
{

    protected $date;

    protected $value;


    public function __construct($date, $value)
    {
        $this->date = Carbon::parse($date);

        $this->value = $value;
    }



    /**
     * Get the price's date.
     *
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the price's value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    public function multiply($factor)
    {
        $this->value = $this->value * $factor;

        return $this;
    }
}