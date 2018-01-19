<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.06.17
 * Time: 10:46
 */

namespace App\Presenters;


use App\Classes\Output\Output;
use App\Classes\Output\Price;
use App\Facades\MetricService\AssetMetricService;

class Payment extends Presenter
{

    private $position;

    private $labels = [
        'buy'       => 'g-bg-teal',
        'sell'      => 'g-bg-red',
        'deposit'   => 'g-bg-blue',
        'withdraw'  => 'g-bg-orange',
        'fees'      => 'g-bg-yellow'
    ];

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->position = $this->getPosition();
    }

    /**
     * @return mixed
     */
    private function getPosition()
    {
        return in_array($this->entity->type, ['buy', 'sell']) ? $this->entity->position : null;
    }


    /**
     * @return string
     * @throws \Throwable
     */
    public function total()
    {
        $total = $this->position
            ? AssetMetricService::value($this->position->asset)
            : $this->payment();

        return $total->formatValue();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function price()
    {
        $price = $this->position
            ? AssetMetricService::price($this->position->asset)
            : $this->payment();

        return $price->formatValue();
    }


    /**
     * @return Price
     */
    private function payment()
    {
        return new Price(null, $this->entity->amount, $this->entity->currency->code);
    }


    public function amount()
    {
        return $this->position ? $this->position->amount : null;
    }

    public function date()
    {
        $date = new Output($this->entity->executed_at);
        return $date->formatDate();
    }

    public function name()
    {
        return $this->instrument() ? $this->instrument()->name : null;
    }

    private function instrument()
    {
        return $this->position ? $this->position->asset->positionable : null;
    }

    public function paymentType()
    {
        return trans('payment.' . $this->entity->type);
    }

    public function paymentTypeLabel()
    {
        return array_get($this->labels, $this->entity->type);
    }

    public function instrumentType()
    {
        if ($this->instrument())
            return trans('instrument.' . $this->instrument()->type(true));
    }

    public function isin()
    {
        return optional($this->instrument())->isin;
    }

    public function wkn()
    {
        return optional($this->instrument())->wkn;
    }

    public function exchange()
    {
        return 'Frankfurt';
    }
}