<?php


namespace App\Entities;


use App\Repositories\Exceptions\FinancialException;



class Stock extends Instrument
{
    protected $fillable = ['symbol'];

    protected $financial = 'App\Repositories\StockFinancial';
    
    public $typeDisp = 'Aktie';
    
}
