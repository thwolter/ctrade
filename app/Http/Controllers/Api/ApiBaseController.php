<?php


namespace App\Http\Controllers\Api;

use App\Entities\Portfolio;
use App\Facades\TimeSeries;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{

    protected function getRedirectUrl()
    {
        return 'api/error';
    }


    public function apiCallError(Request $request)
    {
        return view('api.error');
    }

    /**
     * Returns the portfolio for a requested id.
     *
     * @param Request $request
     * @return Model
     */
    protected function getPortfolio(Request $request)
    {
        return Portfolio::find($request->get('id'));
    }
}