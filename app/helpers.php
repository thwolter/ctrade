<?php


function set_active($path, $active = 'active') {

    return Request::is($path) ? $active : '';
}

function format_price($value)
{
    $fmt = numfmt_create( 'de_DE', NumberFormatter::CURRENCY );

    return numfmt_format_currency($fmt, $value, "EUR")."\n";
}

/**
 * Return the array's value or 0 in case of null value.
 *
 * @param $value
 * @return int|mixed
 */
function array_first_or_null($value)
{
    return is_null($value) ? 0 : array_first($value);
}

