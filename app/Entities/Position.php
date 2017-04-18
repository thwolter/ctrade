<?php

namespace App\Entities;

use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\FinancialRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Yahoo\Financable;



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


    public function amount()
    {
        return $this->amount;
    }

    public function name() {
        return $this->positionable->name();
    }


    public function total() {

        $rate = 1;
        if ($this->portfolio->currency() != $this->currency()) {
            
            $this->financial()->price($this->currency().$this->portfolio->currency());
        }

        return $this->price() * $this->amount() * $rate;
    }


}

