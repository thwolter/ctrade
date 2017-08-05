<?php

namespace App\Presenters;


use App\Repositories\RiskRepository;
use Carbon\Carbon;

class LimitPresenter extends Presenter
{

    public function value()
    {
        return $this->formatPrice($this->entity->value, $this->entity->portfolio->currencyCode());
    }


    public function type()
    {
        switch($this->entity->type->code) {
            case 'absolute':
                $string = 'Absolutes Limit'; break;
            case 'relative':
                $string ='Relatives Limit'; break;
            case 'floor':
                $string = 'Untergrenze'; break;
            case 'target':
                $string = 'Zielwert Limit'; break;
            default:
                $string = 'Limit';
        }

        return $string;
    }

   public function activated()
   {
       if ($this->entity->active) {
           return 'aktiviert';

       } else {
           return 'deaktiviert';
       }
   }
}