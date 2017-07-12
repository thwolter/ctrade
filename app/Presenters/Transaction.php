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
        if ($this->isCash()) {
            $total = $this->entity->cash;
        } else {
            $total = $this->entity->amount * $this->entity->price;
        }
        return $this->formatPrice($total, $this->entity->portfolio->currencyCode());
    }

    public function price()
    {
        if (!$this->isCash()) {
            $price = $this->entity->price;
            return $this->formatPrice($price, $this->entity->portfolio->currencyCode());
        }
    }

    public function date()
    {
        return $this->formatDate($this->entity->date);
    }

    public function type()
    {
        return $this->entity->type->name;
    }

    public function name()
    {
        $instrument = $this->entity->instrumentable;

        if (!is_null($instrument))
            return $instrument->name;
    }

    private function isCash()
    {
        return in_array($this->entity->type->code, ['deposit', 'withdraw']);
    }
}