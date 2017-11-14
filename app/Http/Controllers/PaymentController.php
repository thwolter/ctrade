<?php
namespace App\Http\Controllers;
use App\Entities\Portfolio;
use App\Entities\Transaction;
use App\Http\Requests\PayRequest;
use Illuminate\Http\Request;
class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function index(Portfolio $portfolio)
    {
        return view('payments.index')
            ->with('payments', $portfolio->payments->sortByDesc('executed_at'))
            ->with('portfolio', $portfolio);
    }


    public function create(Portfolio $portfolio)
    {
        return view('payments.create', compact('portfolio'));
    }


    public function store(PayRequest $request)
    {
        $portfolio = Portfolio::find($request->get('id'));

        $request->deposit
            ? $portfolio->deposit($request->all())
            : $portfolio->withdraw($request->all());

        return ['totalCash' => $portfolio->cash()];
    }
}