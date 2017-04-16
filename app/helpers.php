<?php


function mapToType($type)
{
    $type = strtoupper(substr($type, 0, 1));
    $config = [
        'S' => 'Stock',
        'C' => 'Currency',
        'I' => 'Index',
        'E' => 'ETF'
    ];

    if (array_key_exists($type, $config)) return $config[$type];

//    throw \InvalidArgumentException("Type '".$type."' not defined.");
}

function set_active($path, $active = 'active') {

    return Request::is($path) ? $active : '';
}