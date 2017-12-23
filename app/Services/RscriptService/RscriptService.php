<?php

namespace App\Services\RscriptService;


use Illuminate\Support\Facades\Log;

class RscriptService extends BaseRscript
{

    public function portfolioRisk($date, $count)
    {
        Log::info(("Calculate risk for portfolio {$this->entity->id} on {$date}"));
        $script = 'Risk.R';

        $args = [
            'id' => $this->entity->id,
            'date' => $date,
            'count' => $count
        ];
        return $this->execute($script, $args);
    }


    public function portfolioValue($date)
    {
        Log::info(("Calculate value for portfolio {$this->entity->id} on {$date}"));

        $script = 'Value.R';

        $args = [
            'id' => $this->entity->id,
            'date' => $date
        ];

        return $this->execute($script, $args);
    }


    public function stockRisk($date, $count)
    {
        return ['2010-10-10' => 0];
    }
}