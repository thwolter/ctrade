<?php

namespace App\Classes\Output;



class Price extends Output
{


    public function __construct($date, $value, $currency)
    {
        parent::__construct($date, $value, $currency);
    }


    /**
     * Returns a formatted string of the value with currency.
     *
     * @return string
     * @throws \Throwable
     */
    public function formatValue()
    {
        return $this->currencyFormatter()->formatCurrency($this->value, $this->currency);
    }


    private function currencyFormatter()
    {
        return new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
    }


}