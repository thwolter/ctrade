<?php

namespace App\Http\Controllers\Api;

use App\Entities\Stock;
use Illuminate\Http\Request;

class ApiStockController extends ApiBaseController
{

    public function history(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:stocks,id',
            'from' => 'sometimes|date',
            'to' => 'required_with:from|date'
        ]);

        return collect(Stock::find($attributes['id'])->allDataHistory($attributes));
    }
}
