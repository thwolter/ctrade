<?php



function set_active($path, $active = 'active') {

    return Request::is($path) ? $active : '';
}

function format_price($value)
{
    $fmt = numfmt_create( 'de_DE', NumberFormatter::CURRENCY );

    return numfmt_format_currency($fmt, $value, "EUR")."\n";
}

