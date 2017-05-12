<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 07.05.17
 * Time: 18:05
 */

namespace App\Repositories\Metadata;


use App\Entities\Currency;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Repositories\Quandl\Quandldata;

abstract class Metadata
{


    abstract public function symbol($item);

    abstract public function name($item);

    abstract public function currency($item);

    abstract public function model($item);

    public function checkValidity($item)
    {
        return true;
    }

    public function wkn($item)
    {
        return null;
    }

    public function isin($item)
    {
        return null;
    }

    public function sector($item)
    {
        return null;
    }
}