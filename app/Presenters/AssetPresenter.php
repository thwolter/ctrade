<?php

namespace App\Presenters;


use App\Services\MetricServices\AssetMetricService;

class AssetPresenter extends Presenter
{

    protected $metrics;


    public function __construct($entity)
    {
        parent::__construct($entity);

        $this->metrics = app()->make(AssetMetricService::class);
    }


    public function amount()
    {
        return $this->entity->amount();
    }


    public function value($currencyCode = null)
    {
        if (is_null($currencyCode)) {
            return $this->formatPrice($this->entity->value());
        } else {
            return $this->formatPrice($this->entity->value($currencyCode), $currencyCode);
        }
    }


    public function risk()
    {
        return $this->formatPrice($this->metrics->risk($this->entity));
    }


    public function riskRatio()
    {
        return $this->formatPercentage($this->metrics->riskRatio($this->entity));

    }


}