<?php

namespace App\Http\Controllers;

use App\Entities\Portfolio;
use App\Entities\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @param int $id portfolio id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('transactions.index', compact('portfolio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id portfolio id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('transactions.create', compact('portfolio'));
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
