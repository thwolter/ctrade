<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Portfolio;

class RiskController extends Controller
{
     public function index($id)
     {
         $portfolio = Portfolio::findOrFail($id);
         \App\Models\Charts::LineChart();
         \App\Models\Charts::gaugeChart();
         return view('risks.index', compact('portfolio'));
     }
}
