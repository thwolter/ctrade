<?php

namespace App\Repositories\Contracts;


interface PortfolioInterface
{
    public function createPortfolio($user, $attributes);
}