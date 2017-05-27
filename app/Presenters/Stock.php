<?php


namespace App\Presenters;


use Carbon\Carbon;

class Stock extends Presenter
{

    public function priceDate()
    {
        $date = new Carbon(array_keys($this->entity->price())[0]);

        //Todo: setlocale has to be called centralized for a user
        setlocale(LC_TIME, 'German');
        return $date->formatLocalized('%A %d %B %Y');

    }
}