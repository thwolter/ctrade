<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 10:06
 */

namespace App\Library;

//use App\Library\Repository;


class StockRepository extends Repository
{

    function instrument() {

        return 'App\Library\Yahoo\StockFinance';
    }

}