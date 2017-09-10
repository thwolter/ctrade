<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
use App\Events\PortfolioHasChanged;
use App\Rules\AfterLatestTransaction;
use App\Rules\BeforOrEqualToday;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PositionStore extends FormRequest
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
            'type'          => 'required',
            'id'            => 'required',
            'datasourceId'  => 'required',
            'amount'        => 'required|min:0.001',
            'pid'           => 'required|exists:portfolios,id',
            'date'          => [
                'required',
                new AfterLatestTransaction(Portfolio::find($this->pid)),
                new BeforOrEqualToday()
            ],
            'transaction'   => 'required|in:buy',

        ];
    }
}
