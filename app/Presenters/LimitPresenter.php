<?php

namespace App\Presenters;


use App\Classes\Limits\AbstractLimit;


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
        return trans('limits.'.$this->entity->type.'.long');
    }

    public function date()
    {
        return $this->formatDate($this->entity->date);
    }

    public function utilisation()
    {
        $helper = app(AbstractLimit::class, [$this->entity]);
        return $helper->utilisation();
    }
}