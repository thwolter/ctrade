<?php

namespace App\Classes\Output;


use App\Exceptions\OutputException;

class Price extends Output implements OutputInterface
{


    public function __construct($date, $value, $currency)
    {
        // We require the parameters.
        // As they are optional in the parent class, let's specify it.
        parent::__construct($date, $value, $currency);
    }

    public static function fromArray($array, $currency)
    {
        return new self(key($array), array_first($array), $currency);
    }

    public static function make($date, $value, $currency)
    {
        return new self($date, $value, $currency);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->formatValue();
    }

    /**
     * Returns a formatted string of the value with currency.
     *
     * @param int $digits
     * @return string
     * @throws \Throwable
     */
    public function formatValue($digits = 2)
    {
        throw_if($digits > 2,
            new OutputException("Parameter digits must be <= 2; $digits given.")
        );

        return $this->currencyFormatter($digits)->formatCurrency($this->value, $this->currency);
    }

    private function currencyFormatter($digits)
    {
        $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $digits);

        return $fmt;
    }

}