<?php


namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\User;
use App\Facades\MetricService\PortfolioMetricService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class PortfolioRepository
{


    public function getPortfolioById($id)
    {
        return Portfolio::where('id', $id)->first();
    }

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
            'opened_at' => Carbon::parse(array_get($attributes, 'date')),
            'description' => array_get($attributes,'description')
        ]);
        $portfolio->currency()
            ->associate(Currency::find(array_get($attributes,'currency')));

        $category = array_get($attributes, 'category');
        if ($category) {
            Category::make(['name' => $category])->user()->associate($user)->save();
        }

        $user->obtain($portfolio);

        return $portfolio;
    }


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function getPortfolioResource($portfolio, $date)
    {
        $date = Carbon::parse($date)->endOfDay();

        $array = [];
        foreach ($portfolio->assets()->get() as $asset) {
            $array[$asset->id] = $asset->toArray($date);
        }


        return [
            'portfolio' => [
                'name' => $portfolio->name,
                'currency' => $portfolio->currency->code,
                'cash' => PortfolioMetricService::cash($portfolio, $date)->getValue()
            ],
            'assets' => $array
        ];
    }

}