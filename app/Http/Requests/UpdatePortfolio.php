<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Currency;


class UpdatePortfolio extends FormRequest
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
            'id' => 'required|exists:portfolios,id',
            'name' => 'required|min:1|max:60',
            'category' => 'string|nullable',
            'description' => 'string|nullable'
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
            $sameNamedPortfolios = $this->user()->portfolios()
                ->whereName($this->name)->where('id', '!=', $this->id)->get();

            if (count($sameNamedPortfolios)) {
                $validator->errors()->add('name', 'Ein Portfolio mit diesem Namen existiert bereits.');
            };
        
        });
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Wie soll dein Portfolio heißen?',
            'name.max' => 'Bezeichung ist zu lang (max 60 Zeichen).'
        ];
    }
}
