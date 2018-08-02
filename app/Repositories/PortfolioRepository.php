<?php


namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\User;
use App\Facades\AccountService;
use App\Facades\DataService;
use App\Facades\PortfolioService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class PortfolioRepository
{


    public function getPortfolioById($id)
    {
        return Portfolio::where('id', $id)->first();
    }


    /**
     * @return mixed
     */
    public function getUserPortfolios($user)
    {
        return User::findOrFail($user->id)->portfolios;
    }


    /**
     * Create a portfolio with attributes which may be received from a request and persist
     * the portfolio with an assigned user.
     *
     * @param $user
     * @param array $attributes
     * @return Portfolio
     */
    public function createPortfolio($user, $attributes = [])
    {
        $portfolio = new Portfolio;
        $portfolio->name = 'Portfolio ' . max(1, $this->getUserPortfolios($user)->count()) ;

        $user->obtain($portfolio);

        return $portfolio;
    }
}