<?php

namespace App\Http\Resources;

use App\Facades\PortfolioService;
use Illuminate\Http\Resources\Json\Resource;

class AssetHistories extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return PortfolioService::assetHistories($this->resource, $request->all());
    }
}
