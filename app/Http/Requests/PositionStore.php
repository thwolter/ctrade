<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
use App\Events\PortfolioHasChanged;
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
            'date'          => 'required|date',
            'transaction'   => 'required|in:buy'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if ($this->date < Portfolio::find($this->pid)->lastTransactionDate()->toDateString()) {
                $validator->errors()->add('date', trans('validation.transaction.after'));
            }

            if ($this->date > Carbon::now()->endOfDay()) {
                $validator->errors()->add('date', trans('validation.transaction.today'));
            }
        });
    }
}
