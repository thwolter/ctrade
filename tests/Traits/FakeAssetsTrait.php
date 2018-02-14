<?php

namespace Tests\Traits;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Position;


trait FakeAssetsTrait
{


    protected function createAsset($trades, $domestic = true)
    {
        $state = $domestic ? 'domestic' : 'foreign';
        $asset = factory(Asset::class)->states($state)->create();

        if ($domestic) $trades = $this->toDomestic($trades);

        $trades = $this->addAmount($trades);

        foreach ($trades as $trade) {
            $asset->obtain($this->createPosition($trade));
        }

        return $asset;
    }

    /**
     * @param $trades
     * @return mixed
     */
    private function toDomestic($trades)
    {
        array_walk($trades, function (&$trade) {
            $trade['fxrate'] = 1;
        });

        return $trades;
    }

    /**
     * @param $trades
     * @return mixed
     */
    protected function addAmount($trades)
    {
        array_walk($trades, function (&$trade) {
            if (array_has($trade, ['number', 'price', 'fxrate'])) {
                $trade['amount'] = $trade['number'] * $trade['price'] * $trade['fxrate'];
            }
        });

        return $trades;
    }

    /**
     * @param $trade
     * @return Position
     */
    protected function createPosition($trade = [])
    {
        if ($currency = array_get($trade, 'currency')) {
            $position = factory(Position::class)->states($currency)->create();
        } else {
            $position = factory(Position::class)->create();
        }

        $position->update($trade);

        $payment = factory(Payment::class)
            ->make(array_add(array_only($trade, ['type', 'amount', 'executed_at']), 'type', 'settlement'));

        $position->obtain($payment);
        return $position;
    }

    protected function foreignAssetWithTrades($trades)
    {
        $asset = factory(Asset::class)->states('foreign')->create();

        foreach ($trades as $trade) {
            $asset->obtain($this->createPlainPosition($trade));
        }

        return $asset;
    }

    /**
     * @param array $array
     * @param string|null $currency
     *
     * @return Position
     */
    protected function createPlainPosition($array = [], $currency = null)
    {
        $position = $currency
            ? factory(Position::class)->states($currency)->create()
            : factory(Position::class)->create();

        $position->update($array);

        return $position;
    }

    protected function domesticAssetWithTrades($trades)
    {
        $asset = factory(Asset::class)->states('domestic')->create();
        $trades = $this->toDomestic($trades);

        foreach ($trades as $trade) {
            $asset->obtain($this->createPosition($trade));
        }

        return $asset;
    }
}