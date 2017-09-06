<?php


namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Currency;
use App\Entities\Datasource;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\User;

class PositionRepository
{

    public function createPosition($instrument, $datasource = null)
    {
        $position = new Position(['amount' => 0]);
        $position->positionable()->associate($instrument);
        $position->datasource()->associate(Datasource::find($datasource));

        return $position;
    }

}