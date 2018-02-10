<?php

namespace Tests\Traits;

use App\Entities\Asset;
use App\Entities\Position;


trait FakeAssetsTrait
{

    /**
     * @return mixed
     */
    protected function createPosition($array = [])
    {
        $position = factory(Position::class)->create();
        $position->update($array);

        return $position;
    }

    protected function createAssetWithTrades($trades, $currency = 'EUR')
    {
        $asset = factory(Asset::class)->states($currency)->create();

        foreach ($trades as $trade) {
            $asset->obtain($this->createPosition($trade));
        }

        return $asset;
    }


}