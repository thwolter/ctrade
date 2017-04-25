<?php

namespace App\Entities;

use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\Yahoo\Financable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Position extends Model implements PresentableInterface
{

    use Financable;
    
    use Presentable;

    protected $presenter = 'App\Presenters\Position';
    
    protected $financial = 'App\Repositories\Yahoo\CurrencyFinancial';

    protected $fillable = [
        'positionable_type',
        'positionable_id',
        'amount'
    ];


    public function positionable() {

       return $this->morphTo();
    }


    public function portfolio()
    {
        return $this->belongsTo('App\Entities\Portfolio');
    }


    public function price()
    {
        return $this->positionable->price();
    }

    public function currency()
    {
        return $this->positionable->currency();
    }

    public function type()
    {
        return get_class($this->positionable);
    }
    
    public function typeDisp()
    {
        return $this->positionable->typeDisp;
    }


    public function amount()
    {
        return $this->amount;
    }

    public function name() {
        return $this->positionable->name();
    }

    public function symbol() {
        return $this->positionable->symbol;
    }

    
    public function total($currency = null) {
        
        return $this->amount() * $this->price() * $this->convert($currency);
    }
 
    
    public function convert($currency = null) {
        
        if (is_null($currency) or $this->curreny == $currency) return 1;
        
        return $this->financial()->price($this->currency().$currency);
    }

    public function hasCurrency($currency)
    {
        return $this->currency() == $currency;
    }


    public function toArray() {

        return [
            'name' => $this->name(),
            'type' => implode(array_slice(explode('\\', $this->type()),-1)),
            'symbol' => $this->symbol(),
            'currency' => $this->currency(),
            'amount' => $this->amount
        ];
    }

    public function history(Carbon $from = null, Carbon $to = null)
    {
        return $this->positionable->history($from, $to);
    }
}

