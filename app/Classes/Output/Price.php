<?php

namespace App\Classes\Output;


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

    /**
     * Returns a formatted string of the value with currency.
     *
     * @param int $digits
     * @return string
     * @throws \Throwable
     */
    public function formatValue($digits = 2)
    {
        return $this->currencyFormatter($digits)->formatCurrency($this->value, $this->currency);
    }

    private function currencyFormatter($digits)
    {
        $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $digits);

        return $fmt;
    }
}