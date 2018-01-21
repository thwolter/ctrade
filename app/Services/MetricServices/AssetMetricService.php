<?php


namespace App\Services\MetricServices;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Facades\Repositories\KeyfigureRepository;
use App\Facades\RiskService\RiskService;
use Carbon\Carbon;

class AssetMetricService extends MetricService
{

    /**
     * Return the cost value of the asset calculated based on buy/sell positions.
     *
     * @param Asset $asset
     * @return Price
     */
    public function cost(Asset $asset)
    {
        $cost = $this->investment($asset)->getValue() / $asset->amount;
        return new Price($this->now(), $cost, $asset->currency->code);
    }


    /**
     * Return the asset's delta between current value and invested amount.
     *
     * @param Asset $asset
     * @return Price
     */
    public function returnAbsolute(Asset $asset)
    {
        $delta = $this->value($asset)->getValue() - $this->investment($asset)->getValue();
        return new Price($this->now(), $delta, $asset->currency->code);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function returnPercent(Asset $asset)
    {
        $delta = $this->returnAbsolute($asset);
        $ratio =$delta->getValue() / $this->investment($asset)->getValue();

        return new Percent($delta->getDate(), $ratio);
    }

    /**
     * Return the invested amount in an asset based on buy/sell orders.
     *
     * @param Asset $asset
     * @return Price
     */
    public function investment(Asset $asset)
    {
        $investment = 0;

        foreach ($asset->positions as $position) {
            $investment += $position->price * $position->amount;
        }

        return new Price($this->now(), $investment, $asset->currency->code);
    }


    /**
     * Return the risk to value ratio.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function riskToValueRatio(Asset $asset)
    {
        $risk = $this->risk($asset);
        $value = $this->value($asset);

        return new Percent($risk->getDate(), $risk->getValue() / $value->getValue());
    }


    /**
     * Calculates the Asset's value based on latest available price data.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function value(Asset $asset, $exchange = null)
    {
        return $this->price($asset, $exchange)->multiply($asset->amount);
    }


    /**
     * Return the risk for the Asset's confidence level.
     *
     * @param Asset $asset
     * @return Price
     */
    public function risk(Asset $asset)
    {
        $parameters = array_replace_key($asset->portfolio->settings()->all(), 'history', 'count');

        $assetVaR = RiskService::assetVaR($asset, $parameters);
        return new Price($this->priceDate($asset), $assetVaR, $asset->currency->code);
    }


    /**
     * Return the date of the latest available price.
     *
     * @param Asset $asset
     * @return Carbon
     */
    public function priceDate(Asset $asset)
    {
        return $this->price($asset)->getDate();
    }


    /**
     * Return the Asset's price.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function price(Asset $asset, $exchange = null)
    {
        return app()
            ->make('MetricService', [$asset->positionable])
            ->price($asset->positionable, $exchange);
    }


    /**
     * Return the today's date.
     *
     * @return string
     */
    private function now()
    {
        return Carbon::now()->toDateString();
    }

    /*




   public function convert($currencyCode = null)
   {
       if (!$currencyCode or $this->currency->code === $currencyCode) return 1;
       return array_first((new CurrencyRepository($this->currency->code, $currencyCode))->price());
   }
  */
}
