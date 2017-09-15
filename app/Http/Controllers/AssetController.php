<?php

namespace App\Http\Controllers;

use App\Entities\Asset;
use App\Entities\Portfolio;



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
        return view('assets.show')
            ->with('portfolio', $portfolio)
            ->with('asset', $portfolio->assets()->whereSlug($slug)->first());
    }
}
