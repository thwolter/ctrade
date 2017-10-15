<?php

namespace App\Http\Controllers;

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Stock;
use App\Facades\DataService;


class AssetController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display the specified resource.
     *
     * @param Portfolio $portfolio
     * @param string $slug
     * @return \Illuminate\Http\Response
     *
     */
    public function show(Portfolio $portfolio, $slug)
    {
        $asset = $portfolio->assets()->whereSlug($slug)->first();

        $stock = Stock::find($asset->id);
        $exchanges = $stock->exchangesToArray();

        $exchange = array_get($exchanges, '0.code');

        $repo = new DataService($stock->datasources()->whereExchange($exchange)->first());
        $history = array_add($repo->allDataHistory([]), 'currency', 'EUR');

        return view('assets.show', compact('portfolio', 'asset', 'exchanges', 'history'));
    }
}
