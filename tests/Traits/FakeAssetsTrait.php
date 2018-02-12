<?php

namespace Tests\Traits;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Position;


trait FakeAssetsTrait
{

    protected function domesticAssetWithTrades($trades)
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        foreach ($trades as $trade) {
            if (array_has($trade, 'fxrate')) $trade['fxrate'] = 1;
            $asset->obtain($this->createPosition($trade));
        }

        return $asset;
    }

    /**
     * @param array $array
     * @param string|null $currency
     *
     * @return Position
     */
    protected function createPosition($array = [], $currency = null)
    {
        $position = $currency
            ? factory(Position::class)->states($currency)->create()
            : factory(Position::class)->create();

        $position->update($array);

        return $position;
    }

    protected function assetWithTradesAndPayments($trades)
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        foreach ($trades as $trade) {
            if (array_has($trade, 'fxrate')) $trade['fxrate'] = 1;

            $position = $this->createPosition($trade);

            $position->obtain(Payment::make([
                    'amount' => $trade['amount'] * $trade['price'],
                    'type' => 'settlement',
                    'executed_at' => $trade['executed_at']
                ]));

            $asset->obtain($position);
        }

        return $asset;
    }


    protected function foreignAssetWithTrades($trades)
    {
        $asset = factory(Asset::class)->states('foreign')->create();

        foreach ($trades as $trade) {
            $asset->obtain($this->createPosition($trade));
        }

        return $asset;
    }
}