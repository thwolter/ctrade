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

    protected $financial;


    public function positions()
    {
        return $this->morphMany('App\Position', 'positionable');
    }



    public function price() {

        return $this->financial->price();
    }


    public function delta() {}


    public function name() {

        return $this->financial->name();
    }

}
