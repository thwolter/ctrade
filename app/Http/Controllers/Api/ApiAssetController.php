<?php

namespace App\Http\Controllers\Api;

use App\Entities\Asset;
use Illuminate\Http\Request;

class ApiAssetController extends ApiBaseController
{

    public function fetch(Request $request)
    {
        $this->validate($request, [
            'assetId' => 'required|exists:assets,id'
        ]);

        $asset = Asset::find($request->assetId);

        return [
            'instrument'        => $asset->positionable->toArray(),
            'portfolioId'       => $asset->portfolio->id,
            'price'             => array_first($asset->price()),
            'priceDate'         => key($asset->price()),
            'amount'            => $asset->amount(),
            'cash'              => $asset->portfolio->cash(),
        ];
    }
}
