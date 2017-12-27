<?php

namespace App\Classes;


use App\Exceptions\PriceException;
use Carbon\Carbon;


class Price
{

    protected $date;

    protected $value;

    protected $currency;

    protected $percent;

    protected $formats = [
        'decimal' => 1
    ];

    protected $allowed = [
        'double',
        'float',
        'integer',
        'NULL'
    ];



    public function __construct($date, $value)
    {
        $this->date = Carbon::parse($date);

        $this->value = $this->checkType($value);
    }


    static public function make($date, $value)
    {
        return new Price($date, $value);
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


    /**
     * Returns a formatted string of the value with currency.
     *
     * @return string
     * @throws \Throwable
     */
    public function toLocalCurrencyFormat()
    {
        throw_unless($this->currency, new PriceException("'currency' variable not set."));

        return $this->currencyFormater()->formatCurrency($this->value, $this->currency);
    }


    public function toLocalPercentageFormat()
    {
        $decimal = array_get($this->formats, 'decimal', 1);

        return sprintf("%01.{$decimal}f %%", 100 * $this->value);
    }


    public function toLocalDateFormat()
    {
        return Carbon::parse($this->date)->formatLocalized('%d.%m.%Y');
    }


    private function currencyFormater()
    {
        return new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
    }

    /**
     * @param $value
     * @throws \Throwable
     *
     * @return mixed
     */
    private function checkType($value)
    {
        $type = gettype($value);

        throw_unless(
            in_array($type, $this->allowed),
            new PriceException("'value' must be numeric, is: $type"));

        return $value;
    }

}