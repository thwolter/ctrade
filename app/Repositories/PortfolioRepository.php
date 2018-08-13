<?php


namespace App\Repositories;

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\User;


class PortfolioRepository
{


    public function findPortfolioById($id)
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


    public function addCoin($attributes)
    {
        return $this->findPortfolioById($attributes['portfolio'])
            ->obtain(new Asset($attributes));
    }
}