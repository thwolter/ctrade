<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Presentable;

    protected $presenter = \App\Presenters\Transaction::class;

    protected $fillable = [
        'date',
        'amount',
        'price'
    ];

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function instrumentable()
    {
        return $this->morphTo();
    }

    /**
     * @param Portfolio $portfolio
     * @param \DateTime $date
     * @param Position $position
     * @param float $amount
     * @return bool
     */
    public static function buy($portfolio, $date, $position, $amount)
    {
        $type = 'buy';

        return self::saveTransaction($portfolio, $date, $position, $amount, $type);
    }

    public static function sell($portfolio, $date, $position, $amount)
    {
        $type = 'sell';

        return self::saveTransaction($portfolio, $date, $position, $amount, $type);
    }

    public static function deposit($portfolio, $date, $amount)
    {
        $type = 'deposit';

        return self::payment($portfolio, $date, $amount, $type);
    }

    public static function withdraw($portfolio, $date, $amount)
    {
        $type = 'withdraw';

        return self::payment($portfolio, $date, $amount, $type);
    }

    /**
     * @param Portfolio $portfolio
     * @param \DateTime $date
     * @param Position $position
     * @param float $amount
     * @param string $type
     * @return bool
     */
    private static function saveTransaction($portfolio, $date, $position, $amount, $type)
    {
        $transaction = new self([
            'date' => $date,
            'amount' => $amount,
            'price' => array_first($position->price())
        ]);

        $transaction->portfolio()->associate($portfolio);
        $transaction->instrumentable()->associate($position->positionable);
        $transaction->transactionType()->associate(TransactionType::firstOrCreate(['code' => $type]));
        return $transaction->save();
    }

    /**
     * @param $portfolio
     * @param $date
     * @param $amount
     * @param $type
     * @return bool
     */
    private static function payment($portfolio, $date, $amount, $type): bool
    {
        $transaction = new self([
            'date' => $date,
            'amount' => $amount
        ]);

        $transaction->portfolio()->associate($portfolio);
        $transaction->transactionType()->associate(TransactionType::firstOrCreate(['code' => $type]));

        return $transaction->save();
    }

}
