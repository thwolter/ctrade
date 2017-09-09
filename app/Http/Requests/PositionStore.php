<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
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
            'type' => 'required',
            'id' => 'required',
            'datasourceId' => 'required',
            'amount' => 'required|min:0.001',
            'pid' => 'required|exists:portfolios,id',
            'date' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $lastTransaction = Portfolio::find($this->pid)->transactions()->last()->executed_at;

        $validator->after(function($validator) use ($lastTransaction) {
            if ($this->date < $lastTransaction) {
                $validator->errors()
                    ->add('date', 'Datum darf nicht vor der letzten Transaktion liegen.');
            }
        });
    }
}
