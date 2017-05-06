<?php


namespace App\Entities;



class Stock extends Instrument
{
    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = 'App\Repositories\Yahoo\StockFinancial';
    
    public $typeDisp = 'Aktie';

}
