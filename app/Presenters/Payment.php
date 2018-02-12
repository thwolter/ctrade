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
use App\Facades\AssetService;

class Payment extends Presenter
{

    private $position;

    private $labels = [
        'settlement'           => 'g-bg-teal',
        'settlement'          => 'g-bg-red',
        'deposit'       => 'g-bg-blue',
        'payment'    => 'g-bg-orange',
        'fee'          => 'g-bg-yellow'
    ];

    private $describeType = [
        'deposit'       => 'Bareinzahlung',
        'payment'    => 'Barauszahlung',
        'fee'          => 'Gebühren'
    ];

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->position = $this->getPosition();
    }

    private function getPosition()
    {
        return in_array($this->entity->type, ['settlement']) ? $this->entity->position : null;
    }


    /**
     * @return string
     * @throws \Throwable
     */
    public function total()
    {
        return $this->payment()->formatValue();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function price()
    {
        return $this->payment()->formatValue();
    }

    private function payment()
    {
        return new Price(null, $this->entity->amount, $this->entity->currency->code);
    }

    public function amount()
    {
        return optional($this->position)->amount;
    }

    public function date()
    {
        $date = new Output($this->entity->executed_at);
        return $date->formatDate();
    }

    public function name()
    {
        return optional($this->instrument())->name;
    }

    private function instrument()
    {
        return $this->position ? $this->position->asset->positionable : null;
    }

    public function description()
    {
        return array_get($this->describeType, $this->entity->type);
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
        return optional($this->entity->exchange)->code;
    }
}