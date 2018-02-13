<?php

namespace App\Services;


use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Position;


class TransactionService
{

    /**
     * Persist a trade with settlement and fee payment.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     */
    public function trade($portfolio, $attributes)
    {
        $position = Position::make($this->positionAttributes($attributes));
        $asset = Asset::firstOrNew($this->assetAttributes($attributes));

        $portfolio->obtain($asset)->obtain($position);

        $this->paySettlement($portfolio, $attributes, $position);
        $this->payFees($portfolio, $attributes, $position);
    }


    /**
     * Return the position's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function positionAttributes($attributes)
    {
        return [
            'number' => $attributes['number'],
            'price' => $attributes['price'],
            'executed_at' => $attributes['executed']
        ];
    }


    /**
     * Return the asset's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function assetAttributes($attributes)
    {
        return [
            'positionable_type' => $attributes['instrumentType'],
            'positionable_id' => $attributes['instrumentId']
        ];
    }


    /**
     * Return the settlement's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function settlementAttributes($attributes)
    {
        return [
            'type' => $attributes['transaction'],
            'amount' => -$attributes['price'] * $attributes['number'],
            'executed_at' => $attributes['executed']
        ];
    }


    /**
     * Return the exchange's attributes.
     *
     * @param array $attributes
     * @return string|null
     */
    private function exchangeAttributes($attributes)
    {
        return array_get($attributes, 'exchange');
    }


    /**
     * Persist payment of fees.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     * @param Position $position
     */
    public function payFees($portfolio, $attributes, $position = null)
    {
        if ($attributes['fee'] != 0) {

            $portfolio
                ->payments()->create($this->feeAttributes($attributes))
                ->position()->associate($position)
                ->save();
        }
    }

    /**
     * Return the fee's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function feeAttributes($attributes): array
    {
        return [
            'type' => 'fee',
            'amount' => -$attributes['fee'],
            'executed_at' => $attributes['executed']
        ];
    }


    /**
     * Deposit an amount.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     */
    public function deposit($portfolio, $attributes)
    {
        $portfolio->payments()->create($this->depositAttributes($attributes));
    }


    /**
     * Return the deposit's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function depositAttributes($attributes): array
    {
        return [
            'type' => 'payment',
            'amount' => $attributes['amount'],
            'executed_at' => $attributes['date']
        ];
    }


    /**
     * Withdraw an amount.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     */
    public function withdraw($portfolio, $attributes)
    {
        $portfolio->payments()->create($this->withdrawAttributes($attributes));
    }


    /**
     * Return the withdrawal's attributes.
     *
     * @param array $attributes
     * @return array
     */
    private function withdrawAttributes($attributes): array
    {
        return [
            'type' => 'payment',
            'amount' => -$attributes['amount'],
            'executed_at' => $attributes['date']
        ];
    }

    /**
     * Persit the settlement payment.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     * @param Position $position
     */
    private function paySettlement($portfolio, $attributes, $position)
    {
        $payment = $portfolio->payments()->create($this->settlementAttributes($attributes));
        $position->obtain($payment, $this->exchangeAttributes($attributes));
    }


}