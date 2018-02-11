<?php

namespace Tests\Traits;

use App\Entities\Asset;
use App\Entities\Position;


trait FakeAssetsTrait
{

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

    protected function domesticAssetWithTrades($trades)
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        foreach ($trades as $trade) {
            if (array_has($trade, 'fxrate')) $trade['fxrate'] = 1;
            $asset->obtain($this->createPosition($trade));
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