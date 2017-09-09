<?php

namespace App\Http\Requests;

use App\Entities\Portfolio;
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
        $portfolio = Portfolio::find($this->pid);

        $validator->after(function($validator) use ($portfolio) {
            if ($this->date > $portfolio->transactions()->last()->executed_at) {
                $validator->errors()
                    ->add('date', 'Datum muss aktueller sein als bereits vorhande Transaktionen.');
            }

            if ($this->date > Carbon::now()->endOfDay()) {
                $validator->errors()
                    ->add('date', 'Transaktion darf nicht in der Zukunft liegen.');
            }
        });
    }
}
