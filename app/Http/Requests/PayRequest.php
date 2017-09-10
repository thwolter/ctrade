<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
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
            'transaction'   => 'required|in:deposit,withdraw',
            'id'            => 'required|exists:portfolios,id',
            'date'          => 'required|date'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if ($this->date < Portfolio::find($this->id)->lastTransactionDate()->toDateString()) {
                $validator->errors()->add('date', trans('validation.transaction.after'));
            }

            if ($this->date > Carbon::now()->endOfDay()) {
                $validator->errors()->add('date', trans('validation.transaction.today'));
            }
        });
    }
}
