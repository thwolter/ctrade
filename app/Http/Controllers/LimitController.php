<?php

namespace App\Http\Controllers;

use App\Entities\Limit;
use App\Entities\Portfolio;
use Illuminate\Http\Request;

class LimitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Portfolio $portfolio)
    {
        $limits = $portfolio
            ->limits()
            ->with(['portfolio', 'portfolio.currency'])
            ->paginate(5);

        return view('limits.index', compact('portfolio', 'limits'));
    }


    public function create(Portfolio $portfolio)
    {
        return view('limits.create', compact('portfolio'));
    }


    public function edit(Request $request)
    {

    }


    public function store(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'exists:portfolios,id',
            'type' => 'in:absolute,relative,floor,absolute',
            'value' => 'required|numeric',
            'date' => 'sometimes|date|nullable'
        ]);

        $portfolio = Portfolio::find($attributes['id']);
        $portfolio->limits()->create(array_only($attributes, ['type', 'value', 'date']));

        return ['redirect' => route('limits.index', $portfolio)];
    }


    public function update(Request $request)
    {

    }


    public function destroy(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'exists:limits,id',
            'portfolio' => 'string'
        ]);

        Limit::find($attributes['id'])->delete();

        return redirect()->route('limits.index', $attributes['portfolio']);
    }

}
