<?php


namespace App\Repositories;


use App\Entities\Portfolio;
use App\Entities\Transaction;
use App\Entities\TransactionType;
use App\Events\PortfolioHasChanged;
use Carbon\Carbon;

class TransactionRepository
{

    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    public function trade($position, $attributes, $type)
    {
        $sign = ($type == 'buy') ? 1 : -1;

        $transaction = new Transaction([
            'executed_at' => Carbon::parse($attributes['data']),
            'amount' => $attributes['amount'] * $sign,
            'price' => $attributes['price'],
            'value' => $attributes['amount'] * $attributes['price'] * $sign
        ]);

        $transaction->portfolio()->associate($this->portfolio);
        $transaction->position()->associate($position);
        $transaction->instrumentable()->associate($position->positionable);
        $transaction->type()->associate(TransactionType::firstOrCreate(['code' => 'trade']));

        event(new PortfolioHasChanged($this->portfolio, $transaction->executed_at));
        return $transaction->save();
    }


    public function pay($attributes, $type)
    {
        $transaction = new Transaction([
            'executed_at' => Carbon::parse(array_get($attributes, 'date')),
            'value' => $attributes[($type == 'fees') ? 'fees' : 'amount']
        ]);

        $transaction->portfolio()->associate($this->portfolio);
        $transaction->type()->associate(TransactionType::firstOrCreate(['code' => $type]));

        event(new PortfolioHasChanged($this->portfolio, $transaction->executed_at));
        return $transaction->save();
    }

}