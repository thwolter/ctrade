<?php

namespace App\Http\Controllers;

use App\Entities\Transaction;
use App\Http\Requests\PositionStore;
use App\Http\Requests\PositionUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\Position;



class PositionsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($slug)->first();
        return view('positions.index', array_merge(['portfolio' => $portfolio], $request->all()));
    }


    public function create($slug, $entity, $positionSlug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($slug)->first();
        $instrument = resolve('App\\Entities\\'.ucfirst($entity))->findBySlug($positionSlug);

       return view('positions.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PositionStore|Request $request
     * @return array
     */
    public function store(PositionStore $request)
    {
        $portfolio = Portfolio::find($request->pid);
        $instrument = resolve($request->type)->find($request->id);

        $position = $portfolio->makePosition($instrument, $request->datasourceId);

        $portfolio->buy($position->id, $request->amount);
        Transaction::buy($portfolio, Carbon::now(), $position, $request->amount);

        return ['redirect' => route('positions.index', $portfolio->slug)];

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($portfolioSlug, $positionSlug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($portfolioSlug)->first();

        // workaround required as whereHas on polymorphic relationship doesn't work yet
        foreach ($portfolio->positions as $position) {
            if ($position->positionable->slug == $positionSlug) break;
        }

        return view('positions.show', compact('portfolio', 'position'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PositionUpdate $request
     * @return array
     */
    public function update(PositionUpdate $request)
    {
        $amount = $request->amount;
        $id = $request->id;

        $position = Position::find($id);
        $portfolio = $position->portfolio;

        switch ($request->transaction) {
            case 'buy':
                $portfolio->buy($id, $amount);
                Transaction::buy($portfolio, Carbon::now(), $position, $amount);
                break;
            case 'sell':
                $portfolio->sell($id, $amount);
                Transaction::sell($portfolio, Carbon::now(), $position, $amount);
                break;
        }

        return ['redirect' => route('positions.index', $portfolio->slug)];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::find($id)->delete();

        return redirect(route('positions.index', $position->portfolio->id));
    }
}
