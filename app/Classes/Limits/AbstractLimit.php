<?php


namespace App\Classes\Limits;

use App\Entities\Limit;
use App\Repositories\RiskRepository;

abstract class AbstractLimit
{
    protected $limit;
    protected $figures;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
        $this->figures = $this->limit->portfolio->figures();
    }

    abstract public function utilisation();
}