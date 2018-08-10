<?php

namespace App\Classes\DataProvider;

use GuzzleHttp;


const API_URL = 'https://www.cryptocompare.com/api/data/coinlist/';


class CryptoCompare
{
    private $coinlist;


    public function __construct()
    {
        $this->coinlist = $this->fetchCoinList();
    }


    private function fetchCoinList()
    {
        return \Cache::rememberForever('coinlist', function() {

            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', API_URL);

            return json_decode($res->getBody(), true);
        });
    }


    /**
     * @return mixed
     */
    public function getBaseImageUrl()
    {
        return $this->coinlist['BaseImageUrl'];
    }


    public function filterCoinData($string)
    {
        return array_filter($this->getCoindata(), function($item) use ($string) {
            return stripos($item['FullName'], $string) !== false;
        });
    }

    
    public function getCoinList()
    {
        return $this->coinlist['Data'];
    }
}