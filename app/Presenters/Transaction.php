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
        $total = $this->entity->amount * $this->entity->price;
        return $this->formatPrice($total, $this->entity->portfolio->currencyCode());
    }

    public function date()
    {
        return $this->formatDate($this->entity->date);
    }

    public function type()
    {
        return $this->entity->transactionType->name;
    }

    public function name()
    {
        return $this->entity->instrumentable->name;
    }
}