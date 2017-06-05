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
        return $this->priceFormat($total, $this->entity->portfolio->currencyCode());
    }

    public function date()
    {
        return Carbon::parse($this->entity->date)->formatLocalized('%d.%m.%Y');

    }


}