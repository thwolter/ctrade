<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PortfolioAssets extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'portfolio' => $this->portfolioToArray(),
            'assets' => $this->assetsToArray()
        ];
    }

    /**
     * @param $array
     * @return mixed
     */
    private function assetsToArray()
    {
        $array = [];
        foreach ($this->assets()->get() as $asset) {
            $array[$asset->id] = $asset->toArray();
        }
        return $array;
    }

    /**
     * @return array
     */
    private function portfolioToArray()
    {
        return [
            'name' => $this->name,
            'currency' => $this->currency->code,
            'cash' => $this->cash()
        ];
    }
}
