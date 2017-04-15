<?php


namespace App\Repositories;


use App\Repositories\Contracts\InstrumentInterface;


class InstrumentRepository extends Model implements InstrumentInterface
{

    // can be initialized with short or long names
    protected $shortKeys = ['E' =>'ETF', 'S' => 'Stock', 'I' => 'Index', 'C' => 'Currency'];

    // standard settings for blades, model, and financial data
    protected $prefixBlade = 'instruments.';
    protected $prefixModel = 'App\\';
    protected $suffixFinancial = "Financial";

    private $financial;
    private $model;
    private $type;


    /**
     * InstrumentRepository constructor.
     *
     * @param string $type - defining instrument type
     */
    public function __construct($type)
    {
        if (array_key_exists($type, $this->shortKeys)) $type = $this->shortKeys[$type];

        $this->type = strtolower($type);
    }


    /**
     * Static function to create instance of a InstrumentRepository.
     *
     * @param string $type - defining instrument type
     * @return InstrumentRepository
     */
    static public function make($type)
    {
        return new InstrumentRepository($type);

    }

    public function blade()
    {
        return $this->prefixBlade.$this->type;
    }


    private function modelClass()
    {
        return $this->prefixModel.ucfirst($this->type);
    }


    private function financialType()
    {
        return ucfirst($this->type);
    }


    public function firstOrCreate(array $attributes, array $joining = [], $touch = true)
    {
        $this->financial = FinancialRepository::make($this->financialType(), $attributes);
        $this->model = $this->modelClass()::firstOrCreate($attributes, $joining, $touch);

        return $this;
    }


    public function with(array $attributes)
    {
        $this->financial = FinancialRepository::make($this->financialType(), $attributes);

        return $this;
    }
p

    public function positions()
    {
        return $this->model->morphMany('App\Position', 'positionable');
    }


    public function price()
    {
        return $this->financial->price;
    }

    public function name()
    {
        return $this->financial->name;
    }

    public function summary()
    {
        // TODO: Implement summary() method.
    }

    public function symbol()
    {
        return $this->financial->symbol;
    }

    public function type()
    {
        return $this->financial->type;
    }

    public function currency()
    {
        return $this->financial->currency;
    }
}