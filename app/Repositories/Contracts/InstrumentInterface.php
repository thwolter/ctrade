<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10.04.17
 * Time: 20:46
 */

namespace App\Repositories\Contracts;


interface InstrumentInterface
{
    public function positions();

    public function firstOrCreate($request);

    public function price();

    public function delta();

    public function name();
}

