<?php

namespace App\Http\Controllers;

use App\Library\FinanceRepository;
use App\Repositories\InstrumentRepository;
use Illuminate\Http\Request;
use App\Library\StockRepository;

class InstrumentController extends Controller
{
    protected $instrument;
    protected $blade;


    public function __construct($type)
    {
        $this->instrument = InstrumentRepository::make($type);
    }


    public static function make($type) {

        return new InstrumentController($type);
    }



    public function show($symbol, $portfolio) {

        $instrument = $this->instrument->with(['symbol' => $symbol]);
        return view($this->instrument->blade(), compact('portfolio', 'instrument'));
    }

}
