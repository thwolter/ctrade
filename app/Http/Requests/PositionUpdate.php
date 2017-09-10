<?php

namespace App\Http\Requests;

use App\Entities\Position;
use App\Rules\AfterLatestTransaction;
use App\Rules\BeforOrEqualToday;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PositionUpdate extends FormRequest
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
            'amount'        => 'required|min:0.001',
            'transaction'   => 'required|in:buy,sell',
            'id'            => 'required|exists:positions,id',
            'date'          => [
                'required',
                new AfterLatestTransaction(Position::find($this->id)->portfolio),
                new BeforOrEqualToday()
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if ($this->date < Position::find($this->id)->portfolio()->lastTransactionDate()->toDateString()) {
                $validator->errors()->add('date', trans('validation.transaction.after'));
            }

            if ($this->date > Carbon::now()->endOfDay()) {
                $validator->errors()->add('date', trans('validation.transaction.today'));
            }
        });
    }
}
