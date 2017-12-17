<?php

namespace App\Contracts;

interface DataServiceInterface
{
    public function price($date);

    public function priceHistory($attributes);

    public function dataHistory($attributes);
}