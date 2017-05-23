<?php

namespace App\Entities;

use App\Models\QuantModel;
use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\Financable;
use App\Entities\Portfolio;
use App\Repositories\DataRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Position extends Model implements PresentableInterface
{

    use Financable;
    
    use Presentable;

    protected $presenter = \App\Presenters\Position::class;
    
    protected $financial = DataRepository::class;

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
        return $this->belongsTo(Portfolio::class);
    }


    public function price()
    {
        return array_first($this->positionable->price());
    }

    public function currency()
    {
        return $this->positionable->currency;
    }


    public function currencyCode()
    {
        return $this->currency()->code;
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

    public function name() 
    {
        return $this->positionable->name;
    }

    public function symbol() 
    {
        return $this->positionable->symbol;
    }

    
    public function total($currency = null) 
    {
        return $this->amount() * $this->price() * $this->convert($currency);
    }
 
    
    public function convert($currencyCode = null) {
        
        if (is_null($currencyCode) or $this->currencyCode() == $currencyCode) return 1;
        
        return array_first(QuantModel::ccyPrice($this->currencyCode(), $currencyCode));
    }


    public function hasCurrency($currency)
    {
        return $this->currency() == $currency;
    }


    public function toArray() {

        return [
            'name' => $this->name(),
            'type' => implode(array_slice(explode('\\', $this->type()),-1)),
            'symbol' => "{$this->positionable_type}-{$this->positionable_id}",
            'currency' => $this->currency(),
            'amount' => $this->amount
        ];
    }

    public function history($parameter = ['limit' => 250])
    {
        return $this->positionable->history($parameter);
    }
}

