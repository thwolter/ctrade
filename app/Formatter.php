<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 17.04.17
 * Time: 14:53
 */

namespace App;


trait Formatter
{


    public function price_format($value)
    {
        $fmt = numfmt_create( 'de_DE', NumberFormatter::CURRENCY );
        return numfmt_format_currency($fmt, $value, $this->currency());
    }

}