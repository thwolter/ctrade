<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 14.04.17
 * Time: 06:42
 */

namespace App\Repositories;

use App\Repositories\Contracts\FinanceInterface;
use App\Repositories\Contracts\RiskInterface;


class InstrumentRepository implements FinanceInterface, RiskInterface
{

    protected $model;
    protected $financial;
    protected $type;


    public function __construct($type) {

        $this->makeFromType($type);
    }


    static public function make($type) {

        return new InstrumentRepository($type);

    }


    private function makeFromType($type) {

        switch($type) {
            case 'S':
                $this->model = 'App\Stock';
                $this->type = 'Stock';
        }
    }

    public function firstOrCreate(array $attributes, array $joining = [], $touch = true) {

        $this->financial = FinancialRepository::make($this->type, $attributes);
        $this->model::firstOrCreate($attributes, $joining, $touch);

        return $this;

    }

    public function positions()
    {
        return $this->model->morphMany('App\Position', 'positionable');
    }


    public function summary()
    {
        // TODO: Implement summary() method.
    }


    public function price()
    {
        return $this->financial->price();
    }
}