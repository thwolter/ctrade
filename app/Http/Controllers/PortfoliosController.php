<?php

/**
 * @purpose
 *
 * Provides CRUD for
 * portfolio with name and currency
 *
 */

namespace App\Http\Controllers;

use App\Entities\Currency;
use App\Entities\PortfolioImage;
use App\Entities\Transaction;
use App\Http\Requests\CreatePortfolio;
use App\Http\Requests\DeletePortfolio;
use App\Http\Requests\PayRequest;
use App\Http\Requests\UpdatePortfolio;
use App\Repositories\LimitRepository;
use App\Settings\InitialSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class PortfoliosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examplesUser = User::whereName('examples')->first();

        if ($examplesUser) {
            $examples = $examplesUser->portfolios;
        } else {
            $examples = null;
        }

        $portfolios = User::findOrFail(auth()->id())->portfolios;

        return view('portfolios.index', compact('portfolios', 'examples'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currency::eligible();
        return view('portfolios.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePortfolio $request
     * @return array
     */
    public function store(CreatePortfolio $request)
    {
        $portfolio = new Portfolio([
            'name' => $request->get('name'),
            'cash' => $request->get('amount')
        ]);
        $portfolio->currency()
            ->associate(Currency::whereCode($request->get('currency'))->first());

        auth()->user()->obtain($portfolio);

        Transaction::deposit($portfolio, Carbon::now(), $request->get('amount'));

        return [
            'redirect' => route('portfolios.show', $portfolio->slug),
            'cash' => $portfolio->cash,
            'currency' => $portfolio->currencyCode(),
            'id' => $portfolio->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $portfolio = Auth::user()->portfolios()->whereSlug($slug)->first();
        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $slug)
    {
        $portfolio = Auth::user()->portfolios()->whereSlug($slug)->first();
        $user = $portfolio->user;
        $limit = new LimitRepository($portfolio);

        if (! session('active_tab'))
            session(['active_tab' => $request->get('tab')]);

        return view('portfolios.edit',
            compact('portfolio', 'user', 'limit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePortfolio|Request $request
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePortfolio $request, $slug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($slug)->first();

        if ($request->get('name'))
            $portfolio->update(['name' => $request->name]);

        if ($request->get('description'))
            $portfolio->update(['description' => $request->description]);

        $portfolio->save();

        $portfolio->settings()->merge($request->all());

        return redirect(route('portfolios.edit', $slug))
            ->with('message', 'Portfolio erfolgreich geändert.')
            ->with('active_tab', $request->get('active_tab'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        if (!$request->confirmed) {
            return redirect(route('portfolios.edit', $slug))->with('delete', 'confirm');
        }
        else {
            $portfolio = Auth::user()->portfolios()->whereSlug($slug)->first();
            $portfolio->delete($portfolio->id);
            return redirect(route('portfolios.index'));
        }
    }

    public function addImage(Request $request, $id)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $file = $request->file('file');
        $portfolio = Portfolio::find($id);

        if (is_null($portfolio->image))
            $portfolio->addImage($file);

        else
            $portfolio->updateImage($file);

    }

    public function pay(PayRequest $request)
    {
        $portfolio = Portfolio::whereId($request->id)->first();

        switch ($request->transaction) {

            case 'deposit':
                $portfolio->deposit($request->amount);
                Transaction::deposit($portfolio, Carbon::now(), $request->amount);

                break;
            case 'withdraw':
                $portfolio->withdraw($request->amount);
                Transaction::withdraw($portfolio, Carbon::now(), $request->amount);
                break;
        }

        return ['redirect' => route('positions.index', $portfolio->slug)];
    }
}

