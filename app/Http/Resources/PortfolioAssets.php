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
        $array = [
            'portfolio' => [
                'name' => $this->name,
                'currency' => $this->currency->code,
                'cash' => $this->cash()
            ],
            'assets' => []
        ];

        foreach ($this->assets()->get() as $asset)
        {
            $array['assets'][$asset->id] = $asset->toArray();
        }
        return $array;
    }
}
