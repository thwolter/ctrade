<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App\Repository\Instrument;

use App\Repositories\Contracts\InstrumentInterface;


abstract class Instrument implements InstrumentInterface
{
    public function positions()
    {
        return $this->morphMany('App\Position', 'positionable');
    }

    abstract  function price();

    abstract function delta();

    abstract function name();

}
