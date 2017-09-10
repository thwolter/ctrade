<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.06.17
 * Time: 10:46
 */

namespace App\Presenters;


use Carbon\Carbon;

class Transaction extends Presenter
{

    public function total()
    {
        return $this->formatPrice($this->entity->value, $this->entity->portfolio->currencyCode());
    }

    public function price()
    {
        $price = $this->entity->price;

        if ($price)
            return $this->formatPrice($price, $this->entity->portfolio->currencyCode());
    }

    public function date()
    {
        return $this->formatDate($this->entity->executed_at);
    }

    public function type()
    {
        $type = $this->entity->type->code;

        return trans("transactions.{$type}");

    }

    public function name()
    {
        $instrument = $this->entity->instrumentable;

        if (!is_null($instrument))
            return $instrument->name;
    }


    public function instrument()
    {
        $instrument = $this->entity->instrumentable;
        return ($instrument) ? trans("instrument.{$instrument->instrumentType}") : null;
    }

    public function isin()
    {
        $instrument = $this->entity->instrumentable;
        return ($instrument) ? $instrument->isin : null;
    }
}