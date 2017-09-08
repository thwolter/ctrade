<?php

namespace App\Http\Controllers\Api;

use App\Entities\Position;
use App\Repositories\LimitRepository;
use Illuminate\Http\Request;

class ApiPositionController extends ApiBaseController
{

    public function fetch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $position = Position::find($request->id);

        $item = $position->positionable->toArray();
        $price = $position->price();
        $amount = $position->amount;
        $cash = $position->portfolio->cash();

        return compact('item', 'price', 'amount', 'cash');

    }
}
