<?php

namespace App;

use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\FinancialRepository;
use Illuminate\Database\Eloquent\Model;



class Position extends Model implements PresentableInterface
{

    use Presentable;

    protected $presenter = 'App\Presenters\Position';

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
        return $this->belongsTo('App\Portfolio');
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

            $repo = FinancialRepository::make('Currency',
                ['symbol' => $this->currency().$this->portfolio->currency()]);

            $rate = $repo->price;
        }

        return $this->price() * $this->amount() * $rate;
    }


}

