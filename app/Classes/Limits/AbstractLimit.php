<?php


namespace App\Classes\Limits;

use App\Classes\KeyFigures;
use App\Entities\Limit;

abstract class AbstractLimit
{
    protected $limit;
    protected $figures;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
        $this->figures = new KeyFigures($limit->portfolio);
    }

    abstract public function utilisation();
}