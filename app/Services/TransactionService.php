<?php

namespace App\Services;


use App\Entities\Position;
use App\Entities\Asset;


class TransactionService
{

    public function trade($portfolio, $attributes)
    {
        $position = $this->makePosition($attributes);
        $portfolio->assets()->save($this->makeAsset($position, $attributes));

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
            'type' => 'withdrawal',
            'amount' => -$attributes['amount'],
            'executed_at' => $attributes['date']
        ]);
    }


    private function payTrade($portfolio, $attributes, $position)
    {
        $portfolio->payments()->create([
            'type' => $attributes['transaction'],
            'amount' => -$attributes['price'] * $attributes['amount'],
            'executed_at' => $attributes['executed']
        ])->position()->associate($position)->save();
    }


    public function payFees($portfolio, $attributes, $position = null)
    {
        if ($attributes['fees'] != 0) {

            $portfolio->payments()->create([
                'type' => 'fees',
                'amount' => -$attributes['fees'],
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


    private function makeAsset($position, $attributes)
    {
        return Asset::firstOrCreate([
            'positionable_type' => $attributes['instrumentType'],
            'positionable_id' => $attributes['instrumentId']
        ]);
    }

}