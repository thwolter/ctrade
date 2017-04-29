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
         $summary = $portfolio->rscript()->summary(60);

         Charts::LineChart($summary['History']);
         Charts::gaugeChart();

         return view('risks.index', compact('portfolio'));
     }
}
