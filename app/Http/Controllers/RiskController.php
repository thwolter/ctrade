<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Models\Charts;

class RiskController extends Controller
{
     public function index($id)
     {
         $portfolio = Portfolio::findOrFail($id);

         $key = 'summary'.$id;
         if (\Cache::has($key)) {
             $summary = \Cache::get($key);
         } else {
             $summary = $portfolio->rscript()->summary(60);
             \Cache::put($key, $summary, 20);
         }

         Charts::history($summary);
         Charts::riskchart($summary);
         Charts::piechart($summary);

         return view('risks.index', compact('portfolio'));
     }
}
