<?php

namespace App\Entities;

use App\Events\PortfolioHasChanged;
use App\Presenters\Presentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Entities\Transaction
 *
 * @property int $id
 * @property string $date
 * @property int $portfolio_id
 * @property int $type_id
 * @property int $instrumentable_id
 * @property string $instrumentable_type
 * @property int $position_id
 * @property float $amount
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $instrumentable
 * @property-read \App\Entities\Portfolio $portfolio
 * @property-read \App\Entities\Position $position
 * @property-read \App\Entities\TransactionType $type
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereInstrumentableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereInstrumentableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction wherePortfolioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction wherePositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float|null $cash
 * @property string $executed_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Transaction whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Transaction whereExecutedAt($value)
 */
class Transaction extends Model
{
    use Presentable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = \App\Presenters\Transaction::class;

    protected $fillable = [
        'date',
        'amount',
        'price',
        'value',
        'cash',
        'executed_at'
    ];

    protected $dates = ['deleted_at'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function instrumentable()
    {
        return $this->morphTo();
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /**
     * @param Portfolio $portfolio
     * @param Carbon $date
     * @param Position $position
     * @param float $amount
     * @return bool
     */
    public static function buy($portfolio, $date, $position, $amount)
    {
        $type = 'trade';

        return self::saveTransaction($portfolio, $date, $position, $amount, $type);
    }

    public static function sell($portfolio, $date, $position, $amount)
    {
        $type = 'trade';

        return self::saveTransaction($portfolio, $date, $position, -$amount, $type);
    }

    public static function deposit($portfolio, $date, $amount)
    {
        $type = 'payment';

        return self::payment($portfolio, $date, $amount, $type);
    }

    public static function withdraw($portfolio, $date, $amount)
    {
        $type = 'payment';

        return self::payment($portfolio, $date, -$amount, $type);
    }

    /**
     * @param Portfolio $portfolio
     * @param Carbon $date
     * @param Position $position
     * @param float $amount
     * @param string $type
     * @return bool
     */
    private static function saveTransaction($portfolio, $date, $position, $amount, $type)
    {
        $price = array_first($position->price());

        $transaction = new self([
            'executed_at' => $date,
            'amount' => $amount,
            'price' => $price,
            'value' => $amount * $price
        ]);

        $transaction->portfolio()->associate($portfolio);
        $transaction->position()->associate($position);
        $transaction->instrumentable()->associate($position->positionable);
        $transaction->type()->associate(TransactionType::firstOrCreate(['code' => $type]));

        event(new PortfolioHasChanged($portfolio, $date));
        return $transaction->save();
    }

    /**
     * @param $portfolio
     * @param $date
     * @param $amount
     * @param $type
     * @return bool
     */
    private static function payment($portfolio, $date, $amount, $type)
    {
        $transaction = new self([
            'executed_at' => $date,
            'value' => $amount
        ]);

        $transaction->portfolio()->associate($portfolio);
        $transaction->type()->associate(TransactionType::firstOrCreate(['code' => $type]));

        event(new PortfolioHasChanged($portfolio, $date));
        return $transaction->save();
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
