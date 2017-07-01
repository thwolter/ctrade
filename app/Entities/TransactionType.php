<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\TransactionType
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Transaction[] $transactions
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\TransactionType whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\TransactionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\TransactionType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\TransactionType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\TransactionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransactionType extends Model
{

    protected $fillable = ['name'];


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
