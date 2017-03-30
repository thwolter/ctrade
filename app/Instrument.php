<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Instrument extends Model
{
    public function positions()
    {
        return $this->morphMany('App\Position', 'positionable');
    }

    abstract  function price();

    abstract function delta();
}
