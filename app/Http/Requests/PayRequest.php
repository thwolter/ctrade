<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
use App\Rules\AfterLatestTransaction;
use App\Rules\BeforOrEqualToday;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
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
            'amount'        => 'required|min:0.01',
            'deposit'       => 'required|boolean',
            'id'            => 'required|exists:portfolios,id',
            'date'          => [
                'required',
                new AfterLatestTransaction(Portfolio::find($this->id)),
                new BeforOrEqualToday()

            ],
        ];
    }
}
