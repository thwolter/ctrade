<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.06.17
 * Time: 10:46
 */

namespace App\Presenters;


use App\Entities\Position;
use Carbon\Carbon;

class Payment extends Presenter
{

    private function instrument()
    {
        $position = $this->entity->position;
        return $position ? $position->asset->positionable : null;
    }

    private function currencyCode()
    {
        return $this->instrument() ? $this->instrument()->currency->code : null;
    }

    public function total()
    {
        $position = $this->entity->position;

        if ($position) {
            $total = $position->price * $position->amount;
            return $this->formatPrice($total, $this->currencyCode());
        }

    }

    public function price()
    {
        return $this->formatPrice(optional($this->entity->position)->price, $this->currencyCode());
    }

    public function amount()
    {
        return optional($this->entity->position)->amount;
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
        if ($this->instrument())
            return trans('transactions.'.$this->instrument()->type());
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
}