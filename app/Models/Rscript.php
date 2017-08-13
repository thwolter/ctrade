<?php

namespace App\Models;


use App\Models\Exceptions\RscriptException;
use Illuminate\Support\Facades\Storage;

class Rscript extends BaseRscript
{

    public function portfolioRisk($date, $count)
    {
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
        $script = 'Value.R';

        $args = [
            'id' => $this->entity->id,
            'date' => $date
        ];

        return $this->execute($script, $args);
    }


}