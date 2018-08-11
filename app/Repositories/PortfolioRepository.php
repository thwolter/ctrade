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
    public function getUserPortfolios()
    {
        return User::findOrFail($this->getUser()->id)->portfolios;
    }


    /**
     * Create a portfolio and persist it to assigned user.
     *
     * @return Portfolio
     */
    public function createPortfolio()
    {
        $portfolio = new Portfolio([
            'name' => 'Portfolio ' . max(1, $this->countUserPortfolios() + 1)
        ]);

        $this->getUser()->obtain($portfolio);

        return $portfolio;
    }

    /**
     * Count the user's portfolios.
     *
     * @return mixed
     */
    public function countUserPortfolios()
    {
        return $this->getUserPortfolios()->count();
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        return auth()->user();
    }
}