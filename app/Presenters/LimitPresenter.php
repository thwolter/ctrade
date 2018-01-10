<?php

namespace App\Presenters;




class LimitPresenter extends Presenter
{

    private $utilisation;


    public function value()
    {
        return $this->metrics->value($this->entity)->formatValue();
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
        //$this->get('utilisation', $this->metrics->utilisation($this->entity))->formatValue();

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
        return 'description';
    }
}