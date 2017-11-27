<?php

namespace App\Http\Controllers;

use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Repositories\LimitRepository;
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
            'date' => 'sometimes|date'
        ]);

        $portfolio = Portfolio::find($attributes['id']);
        $portfolio->limits()->create(array_only($attributes, ['type', 'value', 'date']));

        return ['redirect' => route('limits.index', $portfolio)];
    }


    public function update(Request $request)
    {

    }

    public function set(Request $request)
    {
        $portfolio = Portfolio::find($request->id);
        $repo = new LimitRepository($portfolio);

        foreach (LimitType::all() as $type) {

            session()->forget('limit_'.$type->code);
            $task = $repo->active($type->code) ? 'changed' : 'set';

            if ($request->exists($type->code)) {
                $saved = $repo->set($type->code, $request->all());

                if (!is_null($saved))
                    session(['limit_'.$type->code => $saved ? $task : 'error']);

            } else {
                $saved = $repo->inactivate($type->code);

                if (!is_null($saved))
                    session(['limit_'.$type->code => $saved ? 'inactive' : 'error']);
            }
        }

        session(['active_tab' => $request->active_tab,]);
        return redirect(route('portfolios.edit', $portfolio->slug));
    }
}
