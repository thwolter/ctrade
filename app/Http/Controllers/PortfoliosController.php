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
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\User;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate(request(), [
            'name' => 'required',
            'currency' => 'required',
            'cash' => 'required'
        ]);

        $portfolio = new Portfolio([
            'name' => $request->get('name'),
            'cash' => $request->get('cash')
        ]);
        $portfolio->currency()
            ->associate(Currency::find($request->get('currency')));

        auth()->user()->obtain($portfolio);

        return redirect(route('portfolios.show', $portfolio->id));
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
        return view('portfolios.edit', compact('portfolio'));
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

        Portfolio::whereId($id)->update([
            'name' => $request->name,
            'confidence' => $request->confidence,
            'period' => $request->period,
            'mailing' => $request->mailing,
            'threshold' => $request->threshold,
            'limit' => $request->limit,
            'limit_abs' => $request->limit_abs == 'yes' ? true : false
        ]);

        return redirect(route('portfolios.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Portfolio::whereId($id)->delete($id);

        return redirect(route('portfolios.index'));
    }

    public function addImage(Request $request, $id)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $portfolio = Portfolio::find($id);

        $file = $request->file('file');
        $image = PortfolioImage::fromForm($file);

        if (is_null($portfolio->image)) {

            $file->storeAs('public/images', $image->path);
            $portfolio->addImage($image);

        } else {

            Storage::delete('public/images/'.$portfolio->image->path);
            $file->storeAs('public/images', $image->path);
            $portfolio->updateImage($image);
        }



    }

}

