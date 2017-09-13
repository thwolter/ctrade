<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
use App\Events\PortfolioHasChanged;
use App\Rules\AfterLatestTransaction;
use App\Rules\BeforOrEqualToday;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'portfolioId'       => 'required|exists:portfolios,id',
            'transaction'       => 'required|string',
            'instrumentType'    => 'required|string',
            'instrumentId'      => 'required|numeric',
            'currency'          => 'required|string',
            'amount'            => 'required|numeric',
            'price'             => 'required|numeric|min:0',
            'fees'              => 'required|nullable|numeric|min:0',
            'executed'          => [
                'required',
                new AfterLatestTransaction(Portfolio::find($this->portfolioId)),
                new BeforOrEqualToday()
            ],


        ];
    }
}
