<?php


namespace App\Repositories;


use App\Repositories\Exceptions\InvalidInstrumentType;

trait FinancialMapping
{
    protected $types = [
        'S' => 'Stock',
        'C' => 'Currency',
        'I' => 'Index',
        'E' => 'ETF',
    ];


    public function mapType($type)
    {
        $typeUpper = strtoupper(substr($type, 0, 1));

        if (array_key_exists($typeUpper, $this->types)) return $this->types[$typeUpper];

        throw new InvalidInstrumentType("Arguemnt 'type=$type' cannot be resolved to ".implode($this->types, ", "));
     }
}