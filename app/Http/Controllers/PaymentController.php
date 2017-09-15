<?php
namespace App\Http\Controllers;
use App\Entities\Portfolio;
use App\Entities\Transaction;
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
            ->with('payments', $portfolio->payments)
            ->with('portfolio', $portfolio);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id transaction id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        $portfolio = $transaction->portfolio;
        return view('transactions.show', compact('portfolio', 'transaction'));
    }
}