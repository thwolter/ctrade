<?php


namespace App\Entities;


use App\Repositories\FinancialRepository;

class Stock extends Instrument
{
    public $blade = 'instruments.stock';

    protected $fillable = ['symbol'];



    public function financial()
    {
        return FinancialRepository::make('Stock', $this->attributes);
    }
}
