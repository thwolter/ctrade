<?php

namespace App\Contracts;

interface DataServiceInterface
{
    public function price($date);

    public function history($dates);

    public function allDataHistory($attributes);
}