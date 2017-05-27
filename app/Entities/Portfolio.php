<?php

namespace App\Entities;

use App\Models\Rscript\Rscriptable;
use App\Entities\Currency;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Financable;


class Portfolio extends Model
{
    use Financable;
    use Presentable;
    use Rscriptable;

    protected $presenter = 'App\Presenters\Portfolio';
    protected $financial = 'App\Repositories\Yahoo\PortfolioFinancial';
    protected $rscriptable = 'App\Models\Rscript\Portfolio';
    
    protected $fillable = [
        'name', 'cash'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function positions()
    {
        return $this->hasMany(Position::class);
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function currencyCode()
    {
        return $this->currency->code;
    }

    public function cash()
    {
        return $this->cash;
    }


    public function total()
    {
        return $this->positions->sum->total($this->currencyCode());
    }


    public function value()
    {
        return $this->total() + $this->cash();
    }
    
    
    public function setCurrency($code)
    {
        $this->currency()->associate(Currency::firstOrCreate(['code' => $code]));
    }
    
    
    public function toArray()
    {
        $array = [
            'name' => $this->name,
            'currency' => $this->currencyCode(),
            'cash' => $this->cash,
            'item' => []
        ];
        $i = 0;
        foreach($this->positions as $position) {

            $array['item'][$i++] = $position->toArray();
        }
        return $array;
    }
    
    
    public function history(String $currency, Carbon $from = null, Carbon $to = null)
    {
        $symbol = $this->currency().$currency;

        $json = $this->financial()->history($symbol, $from, $to);

        return $json;
    }
    
    
    public function obtain($amount, $instrument)
    {
        $position = new Position(['amount' => $amount]);
        $position->positionable()->associate($instrument);

        $this->positions()->save($position);

        return $this;
    }
}
