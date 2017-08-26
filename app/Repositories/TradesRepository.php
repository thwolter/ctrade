<?php


namespace App\Repositories;


use App\Entities\Portfolio;
use Carbon\Carbon;

class TradesRepository
{

    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    /**
     * Rolls the portfolio back to a given date by using the reverse transactions.
     *
     * @param Carbon $date
     * @return array
     */
    public function rollbackToDate($date)
    {
        $array = $this->portfolio->toArray();

        $date = $date->endOfDay();
        $transactions = $this->portfolio->transactions->where('executed_at', '>', $date)->all();

        foreach (array_reverse($transactions) as $transaction) {

            if ($transaction->position) {
                $id = $transaction->position->id;

                $array['items'][$id]['amount'] -= $transaction->amount;
                $array['meta']['cash'] += $transaction->value;

            } else {
                $array['meta']['cash'] -= $transaction->value;
            }
        }
        return $this->cleanup($array);
    }


    /**
     * Cleans the portfolio up by removing items with an amount of 0.
     *
     * @param array $array
     * @return array
     */
    private function cleanup($array)
    {
        foreach ($array['items'] as $key => $value) {
            if (!$value['amount']) {
                array_forget($array['items'], $key);
            }
        }
        return $array;
    }
}