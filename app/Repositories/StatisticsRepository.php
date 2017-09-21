<?php


namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\User;
use App\Facades\TimeSeries;

class StatisticsRepository
{

    protected $portfolio;


    /**
     * @param array $attributes
     * @return \Illuminate\Support\Collection
     */
    public function getAssetsArray($attributes)
    {
        $portfolio = $this->getPortfolio($attributes);

        $items = collect([]);
        foreach ($portfolio->assets as $asset) {
            $items->push($asset->toArrayWithPrice());
        }

        $total = $items->sum('total');

        return collect([
            'assets' => $this->addShare($items->sortByDesc('total'), $total),
            'total' => $total
        ]);
    }


    /**
     * Return 'values' keyFigures from database.
     *
     * @param array $attributes
     * @return array
     */
    public function getValues($attributes)
    {
        return $this->getPortfolio($attributes)->keyFigure('value')->values;
    }


    /**
     * Return 'risk' keyFigures from database.
     *
     * @param array $attributes
     * @return array
     */
    public function getRisks($attributes)
    {
        $portfolio = $this->getPortfolio($attributes);

        $values = $portfolio->keyFigure('risk')->values;
        $keys = array_keys($values);

        $result = [];
        for ($i = 0; $i < count($values); $i++) {

            $result[$keys[$i]] = array_get($values[$keys[$i]], $attributes['conf']);
        }

        return $result;
    }


    /**
     * Return 'risk contribution' keyFigures from database.
     *
     * @param array $attributes
     * @return mixed
     */
    public function getRiskContribution($attributes)
    {
        $contribution = $this->getPortfolio($attributes)->keyFigure('contribution')->values;

        return array_get($contribution, $attributes['date.'.$attributes['conf']]);
    }


    public function getLimitUtilisation($attributes)
    {
        $limits = new LimitRepository($this->getPortfolio($attributes));

        return $limits->utilisation();
    }


   public function getTimeSeries($attributes)
   {
       $values = $this->getValues($attributes);
       $risks = $this->getRisks($attributes);

       $valueAfterRisk = [];
       foreach ($values as $key => $value) {
           $valueAfterRisk[$key] = $value - array_get($risks, $key);
       }
       return collect([
           'values' => $this->getValues($attributes),
           'risk' => $this->getRisks($attributes),
           'valuesAfterRisk' => $valueAfterRisk,
           'limit' => $this->limitTimeSeries($values, 4800),
       ]);
   }


    private function addShare($items, $total)
    {
        $items = $items->toArray();

        foreach ($items as &$item) {
            $item['share'] = $item['total'] / $total;
        }
        return $items;
    }


    private function getPortfolio($attributes)
    {
        if (!$this->portfolio) {
            $this->portfolio = Portfolio::find($attributes['id']);
        }

        return $this->portfolio;
    }


    private function limitTimeSeries($attributes)
    {
        $portfolio = $this->getPortfolio($attributes);
        return array_pad([], count($this->getValues($attributes)), 4000);
    }

}