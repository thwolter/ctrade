<?php

namespace App\Http\Controllers;

use App\Http\Requests\TradeRequest;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\Position;



class AssetController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function tradeStock($portfolioSlug, $assetSlug, $transaction)
    {
        $portfolio = Portfolio::whereSlug($portfolioSlug)->first();
        foreach ($portfolio->assets as $asset) {
            if ($asset->slug === $assetSlug) break;
        }

        $stock = $asset->positionable;

        return view('assets.trade.stock', compact('portfolio', 'stock', 'transaction'));
    }
}
