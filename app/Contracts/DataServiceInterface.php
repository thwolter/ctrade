<?php

namespace App\Contracts;

interface DataServiceInterface
{
    public function price($date);

    public function priceHistory($dates);

    public function dataHistory($attributes);
}