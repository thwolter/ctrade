<?php

namespace App\Presenters;


use App\Repositories\RiskRepository;
use Carbon\Carbon;

class LimitPresenter extends Presenter
{

    public function value()
    {
        if ($this->entity->type == 'relative') {
            $string = $this->entity->value. '%';

        } else {
            $string = $this->formatPrice($this->entity->value, $this->entity->portfolio->currency->code);

        }
        return $string;
    }


    public function type()
    {
        return trans('limits'.$this->entity->type.'form.title');
    }

    public function date()
    {
        return $this->formatDate($this->entity->date);
    }
}