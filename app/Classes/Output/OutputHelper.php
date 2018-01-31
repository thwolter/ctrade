<?php


namespace App\Classes\Output;


use Carbon\Carbon;

trait OutputHelper
{

    protected $priceAttributes;


    public function __call($name, $arguments)
    {
        $value = $this->$name($arguments);

        if ($this->priceAttributes) {
            $value = new Price($this->priceAttributes['date'], $value, $this->priceAttributes['currency']);
        }

        return $value;
    }


    protected function asPrice($asset, $parameter)
    {
        $this->priceAttributes = [
            'date' => array_get($parameter, 'date', Carbon::now()->toDateString()),
            'currency' => $asset->currency->code
        ];

        return $this;
    }
}