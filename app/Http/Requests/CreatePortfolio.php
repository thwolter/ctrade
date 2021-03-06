<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Currency;


class CreatePortfolio extends FormRequest
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
            'name'          => 'required|min:1|max:60',
            'currency'      => 'exists:currencies,code',
            'manage'        => 'required|boolean',
            'amount'        => 'required_if:manage,true|min:0',
            'date'          => 'required_with:amount|before_or_equal:'.Carbon::today(),
            'transaction'   => 'required_with:amount:in:deposit'
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        
        $validator->after(function ($validator) {
            
            // check if the user already has a portfolio with this name
            if (count($this->user()->portfolios()->whereName($this->name)->get())) {
                $validator->errors()->add('name', trans('portfolio.name'));
            };
        
        });
    }


    public function messages()
    {
        return [
            'date.before_or_equal'  => trans('validation.portfolio.date'),
            'amount.required_if'    => trans('validation.portfolio.amount')
        ];
    }
}
