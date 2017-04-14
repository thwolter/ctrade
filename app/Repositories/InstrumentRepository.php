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

    public function __construct($type) {

        $this->model = $this->map($type);
    }

    static public function make($type) {

        return new InstrumentRepository($type);

    }


    private function map($type) {

        switch($type) {
            case 'S': return 'App\Stock';
        }
    }

    public function firstOrCreate(array $attributes, array $joining = [], $touch = true) {

        $this->model::firstOrCreate($attributes, $joining, $touch);

    }

    public function positions()
    {
        return $this->morphMany('App\Position', 'positionable');
    }


    public function summary($symbol)
    {
        // TODO: Implement summary() method.
    }


    public function price($symbol)
    {
        // TODO: Implement price() method.
    }
}