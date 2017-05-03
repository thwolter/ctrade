<?php


namespace App\Entities;



class Stock extends Instrument
{
    protected $fillable = ['symbol'];

    protected $financial = 'App\Repositories\Yahoo\StockFinancial';
    
    public $typeDisp = 'Aktie';
    
}
