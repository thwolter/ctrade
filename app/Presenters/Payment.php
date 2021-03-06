<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.06.17
 * Time: 10:46
 */

namespace App\Presenters;


class Payment extends Presenter
{

    private $position;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->position = $this->getPosition();
    }

    private function instrument()
    {
        return $this->position ? $this->position->asset->positionable : null;
    }

    private function currencyCode()
    {
        return $this->instrument()
            ? $this->instrument()->currency->code
            : $this->entity->portfolio->currency->code;
    }

    public function total()
    {
        return $this->formatPrice($this->entity->amount, $this->currencyCode());
    }

    public function price()
    {
        return $this->position ? $this->formatPrice($this->position->price, $this->currencyCode()) : null;
    }

    public function amount()
    {
        return $this->position ? $this->position->amount : null;
    }

    public function date()
    {
        return $this->formatDate($this->entity->executed_at);
    }

    public function name()
    {
       return $this->instrument() ? $this->instrument()->name : null;
    }

    public function paymentType()
    {
        return trans('payment.'.$this->entity->type);
    }

    public function instrumentType()
    {
        if ($this->instrument())
            return trans('instrument.'.$this->instrument()->type(true));
    }

    public function isin()
    {
        return $this->instrument() ? $this->instrument()->isin : null;
    }

    /**
     * @return mixed
     */
    private function getPosition()
    {
        return in_array($this->entity->type, ['buy', 'sell']) ? $this->entity->position : null;
    }
}