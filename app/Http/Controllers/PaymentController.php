<?php
namespace App\Http\Controllers;

use App\Entities\Portfolio;
use App\Entities\Transaction;
use App\Facades\AccountService;
use App\Facades\PortfolioService;
use App\Http\Requests\PayRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;


class PaymentController extends Controller
{

    protected $transaction;


    public function __construct(TransactionService $transaction)
    {
        $this->middleware('auth');

        $this->transaction = $transaction;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function index(Portfolio $portfolio)
    {
        $payments = $portfolio->payments()
            ->orderByDesc('executed_at')
            ->paginate(10);

        return view('payments.index', compact('portfolio', 'payments'));
    }


    /**
     * Call a view to create a resource.
     *
     * @param Portfolio $portfolio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Portfolio $portfolio)
    {
        return view('payments.create', compact('portfolio'));
    }


    /**
     * Store the payment.
     *
     * @param PayRequest $request
     * @return array
     */
    public function store(PayRequest $request)
    {
        $portfolio = Portfolio::find($request->get('id'));

        $request->deposit
            ? $this->transaction->deposit($portfolio, $request->all())
            : $this->transaction->withdraw($portfolio, $request->all());

        return ['totalCash' => AccountService::balance($portfolio)->getValue()];
    }
}