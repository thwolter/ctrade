<?php

namespace App\Contracts;

interface DataServiceInterface
{
    public function price($date = null);

    public function history($dates = null);

    public function allDataHistory($attributes);
}