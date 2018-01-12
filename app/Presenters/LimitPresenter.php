<?php

namespace App\Presenters;

use App\Classes\Limits\LimitEnhancer;


class LimitPresenter extends Presenter
{
    use LimitEnhancer;

    private $utilisation;
    private $value;


    public function value($digits = 2)
    {
        if (!$this->value) {
            $this->value = $this->metrics->value($this->entity);
        }
        return $this->value->formatValue($digits);
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
        if (!$this->utilisation) {
            $this->utilisation = $this->metrics->utilisation($this->entity);
        }
        return $this->utilisation->formatValue();
    }


    public function utilisationNumber()
    {
        if (!$this->utilisation) {
            $this->utilisation = $this->metrics->utilisation($this->entity);
        }
        return $this->utilisation->getValue();
    }


    public function description()
    {
        //
    }


    public function title()
    {
        return $this->enhance($this->entity)->title();
    }
}