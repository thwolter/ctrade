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
use App\Http\Requests\CreatePortfolio;
use App\Http\Requests\PayRequest;
use App\Http\Requests\UpdatePortfolio;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\User;
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
        $examples = User::whereName('examples')->first()->portfolios;
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
     * @param  CreatePortfolio  $request
     * @return \Illuminate\Http\Response
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

        return [
            'redirect' => route('portfolios.show', $portfolio->id),
            'cash' => $portfolio->cash,
            'currency' => $portfolio->currencyCode(),
            'id' => $portfolio->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolios.edit', compact('portfolio', 'url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( $request->delete == 'yes')
            return view('portfolios.delete', compact('id'));

        $portfolio = Portfolio::whereId($id)->first();
        $portfolio->settings()->merge($request->all());
        $portfolio->update(['name' => $request->name]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::whereId($id);

        //$portfolio->deleteImage();
        $portfolio->delete($id);


        return redirect(route('portfolios.index'));
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
        
        switch($request->transaction) {
            
            case 'deposit':
                $portfolio->deposit($request->amount);
                break;
            case 'withdraw':
                $portfolio->withdraw($request->amount);
                break;
        }
        
        return ['redirect' => route('positions.index', $portfolio->id)];
    }

   
}

