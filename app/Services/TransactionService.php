<?php

namespace App\Services;


use App\Entities\Exchange;
use App\Entities\Position;
use App\Entities\Asset;


class TransactionService
{

    public function trade($portfolio, $attributes)
    {
        $position = $this->makePosition($attributes);

        $portfolio->assets()->firstOrCreate([
            'positionable_type' => $attributes['instrumentType'],
            'positionable_id' => $attributes['instrumentId']
        ])->obtain($position);

        $this->payTrade($portfolio, $attributes, $position);
        $this->payFees($portfolio, $attributes, $position);
    }


    public function deposit($portfolio, $attributes)
    {
        $portfolio->payments()->create([
            'type' => 'deposit',
            'amount' => $attributes['amount'],
            'executed_at' => $attributes['date']
        ]);
    }


    public function withdraw($portfolio, $attributes)
    {
        $portfolio->payments()->create([
            'type' => 'payment',
            'amount' => -$attributes['amount'],
            'executed_at' => $attributes['date']
        ]);
    }


    private function payTrade($portfolio, $attributes, $position)
    {
        $payment = $portfolio->payments()->create([
            'type' => $attributes['transaction'],
            'amount' => -$attributes['price'] * $attributes['amount'],
            'executed_at' => $attributes['executed']
        ]);
        $payment->position()->associate($position)->save();
        $payment->exchange()->associate($this->getExchange($attributes))->save();
    }


    private function getExchange($attributes)
    {
        return Exchange::whereCode(array_get($attributes, 'exchange'))->first();
    }


    public function payFees($portfolio, $attributes, $position = null)
    {
        if ($attributes['fee'] != 0) {

            $portfolio->payments()->create([
                'type' => 'fee',
                'amount' => -$attributes['fee'],
                'executed_at' => $attributes['executed']
            ])->position()->associate($position)->save();
        }
    }


    private function makePosition($attributes)
    {
        return Position::make([
            'amount' => $attributes['amount'],
            'price' => $attributes['price'],
            'executed_at' => $attributes['executed']
        ]);
    }


}