<?php

namespace App\Http\Controllers;

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
     * @param string $portfolioSlug
     * @param string $assetSlug
     * @return \Illuminate\Http\Response
     *
     */
    public function show($portfolioSlug, $assetSlug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($portfolioSlug)->first();

        foreach ($portfolio->positions as $position) {
            if ($position->positionable->slug == $assetSlug) break;
        }

        return view('positions.show', compact('portfolio', 'position'));
    }
}
