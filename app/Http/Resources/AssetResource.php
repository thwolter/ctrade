<?php

namespace App\Http\Resources;


use App\Facades\MetricService\AssetMetricService;
use Illuminate\Http\Resources\Json\Resource;


class AssetResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = [];

        foreach ($this->assets as $asset) {

            $price = AssetMetricService::price($asset);
            $value = AssetMetricService::value($asset);


            array_push($items, array_merge($asset->toArray(), [
                'price' => $price->getValue(),
                'value' => $value->getValue(),
                'date' => $price->getDateString(),
                'currency' => $asset->currency->code
            ]));
        }

        return $items;
    }
}
