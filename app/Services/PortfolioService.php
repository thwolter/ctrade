<?php

namespace App\Services;


use App\Entities\Portfolio;
use App\Entities\Position;

class PortfolioService
{

    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    public function storeTrade($attributes)
    {
        $position = Position::make([
            'amount' => $attributes['amount'],
            'price' => $attributes['price'],
            'executed_at' => $attributes['executed']
        ]);

        $this->portfolio->assets()->firstOrCreate([
            'positionable_type' => $attributes['instrumentType'],
            'positionable_id' => $attributes['instrumentId']
        ])->obtain($position);

        $this->payTrade($attributes, $position);
        $this->payFees($attributes, $position);
    }


    private function payTrade($attributes, $position)
    {
        $this->portfolio->payments()->create([
            'type' => $attributes['transaction'],
            'amount' => -$attributes['price'] * $attributes['amount'],
            'executed_at' => $attributes['executed']
        ])->position()->associate($position)->save();
    }


    public function payFees($attributes, $position = null)
    {
        if ($attributes['fees'] != 0) {

            $this->portfolio->payments()->create([
                'type' => 'fees',
                'amount' => -$attributes['fees'],
                'executed_at' => $attributes['executed']
            ])->position()->associate($position)->save();
        }
    }


    public function deposit($attributes)
    {
        $this->portfolio->payments()->create([
            'type' => 'deposit',
            'amount' => $attributes['amount'],
            'executed_at' => $attributes['date']
        ]);
    }


    public function withdraw($attributes)
    {
        $this->portfolio->payments()->create([
            'type' => 'withdrawal',
            'amount' => -$attributes['amount'],
            'executed_at' => $attributes['date']
        ]);
    }
}