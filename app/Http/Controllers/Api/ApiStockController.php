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
            'from' => 'required_without:date|date',
            'to' => 'required_with:from|date'
        ]);

        return Stock::find($request->id)->rawHistory($attributes);
    }
}
