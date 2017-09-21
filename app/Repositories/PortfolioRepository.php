<?php


namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\User;
use App\Facades\TimeSeries;

class PortfolioRepository
{

    /**
     * Create a portfolio with attributes which may be received from a request and persist
     * the portfolio with an assigned user.
     *
     * @param $user
     * @param array $attributes
     * @return Portfolio
     */
    public function createPortfolio($user, $attributes)
    {
        $portfolio = new Portfolio([
            'name' => array_get($attributes,'name'),
            'cash' => 0,
            'description' => array_get($attributes,'description')
        ]);
        $portfolio->currency()
            ->associate(Currency::whereCode(array_get($attributes,'currency'))->first());

        $category = array_get($attributes, 'category');
        if ($category) {
            Category::make(['name' => $category])->user()->associate($user)->save();
        }

        $user->obtain($portfolio);
        $portfolio->deposit($attributes);

        return $portfolio;
    }
}