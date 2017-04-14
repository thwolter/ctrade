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
    protected $classModel;


    /**
     * InstrumentRepository constructor.
     *
     * @param string $type - defining instrument type
     */
    public function __construct($type) {

        $this->map($type);
    }


    /**
     * Static function to create instance of a InstrumentRepository.
     *
     * @param string $type - defining instrument type
     * @return InstrumentRepository
     */
    static public function make($type) {

        return new InstrumentRepository($type);

    }


    /**
     * Map instrument type to financial class and model class.
     *
     * @param string $type
     */
    private function map($type) {

        $type = strtoupper(substr($type, 0,1));

        switch($type) {
            case 'S': //Stock
                $this->classModel = 'App\Stock';
                $this->type = 'Stock';
                break;
            case 'E': //ETF
                $this->classModel = 'App\Stock';
                $this->type = 'Stock';
                break;
            case 'I': //Index
                $this->classModel = 'App\Stock';
                $this->type = 'Stock';
                break;
            case 'C': //Currency
                $this->classModel = 'App\FX';
                $this->type = 'Fx';
                break;
            default:
                throw new \Exception("Parameter 'type' must be [S]tock, [E]TF, [I]ndex, of [C]urrency");
                break;
        }
    }

    public function firstOrCreate(array $attributes, array $joining = [], $touch = true) {

        $this->financial = FinancialRepository::make($this->type, $attributes);
        $this->model = $this->classModel::firstOrCreate($attributes, $joining, $touch);

        return $this;

    }

    public function positions()
    {
        return $this->model->morphMany('App\Position', 'positionable');
    }


    public function price()
    {
        return $this->financial->price;
    }

    public function summary()
    {
        // TODO: Implement summary() method.
    }
}