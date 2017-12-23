<?php

namespace App\Classes;


use Carbon\Carbon;

class Price
{

    protected $date;

    protected $value;

    protected $currency;

    protected $percent;



    public function __construct($date, $value)
    {
        $this->date = Carbon::parse($date);

        $this->value = $value;
    }


    static public function make($data, $value)
    {
        return new Price($data, $value);
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


    public function getDateString()
    {
        return $this->date->toDateString();
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


    /**
     * Multiply the value with a factor.
     *
     * @param $factor
     * @return $this
     */
    public function multiply($factor)
    {
        $this->value = $this->value * $factor;

        return $this;
    }


    /**
     * Set a currency.
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency(String $currency)
    {
        $this->currency = $currency;

        return $this;
    }


    /**
     * Specify whether the value represents a percentage value.
     *
     * @param bool $percent
     * @return $this
     */
    public function setPercent(Bool $percent)
    {
        $this->percent = $percent;

        return $this;
    }

}