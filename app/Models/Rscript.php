<?php

namespace App\Models;


use Illuminate\Support\Facades\Log;

class Rscript extends BaseRscript
{

    public function portfolioRisk($date, $count)
    {
        Log::info(("Calculate risk for portfolio {$this->entity->id} at {$date}"));
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
        Log::info(("Calculate value for portfolio {$this->entity->id} at {$date}"));

        $script = 'Value.R';

        $args = [
            'id' => $this->entity->id,
            'date' => $date
        ];

        return $this->execute($script, $args);
    }


}