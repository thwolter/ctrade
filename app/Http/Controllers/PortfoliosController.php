<?php


namespace App\Http\Controllers;

use App\Entities\Portfolio;
use App\Http\Requests\CreatePortfolio;
use App\Http\Requests\UpdatePortfolio;
use App\Repositories\PortfolioRepository as Repository;
use Illuminate\Http\Request;


class PortfoliosController extends Controller
{

    protected $repository;


    public function __construct(Repository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = $this->repository->getUserPortfolios();

        return view('portfolios.index', compact('portfolios'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $portfolio = $this->repository->createPortfolio();

        return redirect()->route('portfolios.show', [$portfolio->slug]);
    }


    /**
     * Display the specified resource.
     *
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        $id = $portfolio->id;
        $portfolios = $this->repository->getUserPortfolios();

        return view('portfolios.index', compact('portfolios', 'id'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Portfolio $portfolio)
    {
       //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePortfolio|Request $request
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePortfolio $request, Portfolio $portfolio)
    {
       //
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
       //
    }
}

