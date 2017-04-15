<?php


namespace App;


use App\Repositories\FinancialRepository;

class Stock extends Instrument
{
    protected $blade = 'instruments.stock';

    protected $fillable = ['symbol'];



    public function financial()
    {
        return FinancialRepository::make('Stock', $this->attributes);
    }
}
