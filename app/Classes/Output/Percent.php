<?php

namespace App\Classes\Output;



class Percent extends Output implements OutputInterface
{
   const DEFAULT_DECIMAL =1;


    public function __construct($date, $value)
    {
        parent::__construct($date, $value, null);
    }


    public function formatValue()
    {
        $decimal = array_get($this->formats, 'decimal', self::DEFAULT_DECIMAL);

        return sprintf("%01.{$decimal}f %%", 100 * $this->value);
    }

}