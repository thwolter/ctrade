<?php


namespace App\Repositories;


use App\Entities\Portfolio;
use App\Entities\Position;
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


    /**
     * Persist a new transaction for a buy/sell trade of a position.
     *
     * @param Position $position
     * @param array $attributes
     * @return bool
     */
    public function trade($position, $attributes)
    {
        $transaction = $this->makeTransaction($attributes);

        $transaction->position()->associate($position);
        $transaction->instrumentable()->associate($position->positionable);

        return $transaction->save();
    }


    /**
     * Persist a new transaction for a cash withdrawal/deposit on a portfolio.
     *
     * @param array $attributes
     * @return bool
     */
    public function pay($attributes)
    {
        $transaction = $this->makeTransaction($attributes);

        return $transaction->save();
    }


    /**
     * Persist a new transaction for a fee made on a trade or payment.
     *
     * @param array $attributes
     * @return bool
     */
    public function fees($attributes)
    {
        $transaction = $this->makeTransaction($attributes);
        $transaction->value = $attributes['value'];

        return $transaction->save();
    }

    /**
     * Returns a new transaction without persisting it. The attributes amount is
     * set as value by default and should be overwritten if required.
     *
     * @param array $attributes
     * @return Transaction
     */
    private function makeTransaction($attributes): Transaction
    {
        if (array_has($attributes, ['buy', 'sell'])) {
            $sign = ($attributes['type'] == 'buy') ? 1 : -1;
            $amount = $attributes['amount'] * $sign;
            $price = $attributes['price'];
        }

        $transaction = new Transaction([
            'executed_at' => Carbon::parse(array_get($attributes, 'date')),
            'value' => $attributes['amount'],
            'amount' => isset ($amount) ? $amount : null,
            'price' => isset ($price) ? $price : null
        ]);

        $type = TransactionType::firstOrCreate(['code' => $attributes['type']]);

        $transaction->portfolio()->associate($this->portfolio);
        $transaction->type()->associate($type);

        event(new PortfolioHasChanged($this->portfolio, $transaction->executed_at));
        return $transaction;
    }

}