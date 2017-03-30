<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Instrument
{
    protected $fillable = [
        'symbol',
        'currency'
    ];


    public function price()
    {
        // TODO: Implement price() method.
    }


    public function delta()
    {
        // TODO: Implement delta() method.
    }


}
