<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11.04.17
 * Time: 07:53
 */

namespace App\Repositories;


class RepositoryInstrument extends Instrument
{

    public function price() {

        $this->model->price();
    }

    public function delta() {

        $this->model->delta();
    }

    public function name() {

        $this->model->name();
    }
}