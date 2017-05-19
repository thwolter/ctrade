<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $fillable = [
        'code', 'elibible'
    ];


    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }


    static public function eligible()
    {
        $eligible = [];
        $currencies = Currency::whereEligible(true)->get();

        foreach ($currencies as $currency)
        {
            $eligible[] = $currency->code;
        };

        return $eligible;
    }
}
