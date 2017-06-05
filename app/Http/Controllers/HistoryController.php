<?php

namespace App\Http\Controllers;

use App\Entities\Portfolio;
use App\Models\Charts;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $key = 'summary'.$id;
        if (\Cache::has($key)) {
            $summary = \Cache::get($key);
        } else {
            $summary = $portfolio->rscript()->summary(60);
            \Cache::put($key, $summary, 0);
        }

        Charts::history($summary);

        return view('history.index', compact('portfolio'));
    }
}
