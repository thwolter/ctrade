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
            $string = $this->formatPrice($this->entity->value, [
                'currency' => $this->entity->portfolio->currency->code
            ]);

        }
        return $string;
    }


    public function type()
    {
        return trans("limits.{$this->entity->type}.long");
    }


    public function date()
    {
        $date = $this->entity->date;

        return $date ? $this->formatDate($this->entity->date) : null;
    }


    public function utilisation()
    {
        return $this->formatPercentage($this->entity->calc()->utilisation(), 0);
    }


    public function description()
    {
        return 'description';
    }
}