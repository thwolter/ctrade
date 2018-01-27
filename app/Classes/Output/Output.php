<?php

namespace App\Classes\Output;


use App\Exceptions\AllowedTypeException;
use Carbon\Carbon;

class Output
{
    protected $date;
    protected $value;
    protected $allowed = [
        'double',
        'float',
        'integer',
        'NULL'
    ];
    protected $currency;
    protected $formats = [];


    public function __construct($date, $value = null, $currency = null)
    {
        $this->date = Carbon::parse($date);
        $this->value = $this->checkType($value);
        $this->currency = $currency;
    }

    /**
     * @param $value
     * @throws \Throwable
     *
     * @return mixed
     */
    protected function checkType($value)
    {
        $type = gettype($value);

        throw_unless(
            in_array($type, $this->allowed),
            new AllowedTypeException("'value' must be numeric, is: $type"));

        return $value;
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


    public function getCurrency()
    {
        return $this->currency;
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
     * @return mixed
     */
    public function multiply($factor)
    {
        $this->value = $this->value * $factor;

        return $this;
    }

    public function formatDate()
    {
        return Carbon::parse($this->date)->formatLocalized('%d.%m.%Y');
    }
}