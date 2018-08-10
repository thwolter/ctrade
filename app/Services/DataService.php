<?php


namespace App\Services;


use App\Classes\DataProvider\CryptoCompare;

class DataService
{
    private $provider;


    public function __construct()
    {
        $this->provider = new CryptoCompare();
    }

    public function coinList()
    {
        return $this->provider->getCoinList();
    }

}