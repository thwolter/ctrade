<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use App\Facades\MetricService\PortfolioMetricService;


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
        $date = Carbon::parse($request->date)->endOfDay();

        return [
            'portfolio' => $this->portfolioToArray($date),
            'assets' => $this->assetsToArray($date)
        ];
    }

    /**
     * @param $array
     * @return mixed
     */
    private function assetsToArray($date)
    {
        $array = [];
        foreach ($this->assets()->get() as $asset) {
            $array[$asset->id] = $asset->toArray($date);
        }
        return $array;
    }

    /**
     * @return array
     */
    private function portfolioToArray($date)
    {
        return [
            'name' => $this->name,
            'currency' => $this->currency->code,
            'cash' => PortfolioMetricService::cash($this->resource, $date)->getValue()
        ];
    }
}
