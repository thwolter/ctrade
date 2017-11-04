<?php

namespace App\Http\Controllers;

use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Notifications\LimitChanged;
use App\Repositories\LimitRepository;
use Illuminate\Http\Request;

class LimitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function set(Request $request)
    {
        $portfolio = Portfolio::find($request->id);
        $repo = new LimitRepository($portfolio);

        foreach (LimitType::all() as $type) {

            session()->forget('limit_'.$type->code);
            $task = $repo->active($type->code) ? 'changed' : 'set';

            if ($request->exists($type->code)) {
                $saved = $repo->set($type->code, $request->all());

                if (!is_null($saved))
                    session(['limit_'.$type->code => $saved ? $task : 'error']);

            } else {
                $saved = $repo->inactivate($type->code);

                if (!is_null($saved))
                    session(['limit_'.$type->code => $saved ? 'inactive' : 'error']);
            }
        }

        session(['active_tab' => $request->active_tab,]);
        return redirect(route('portfolios.edit', $portfolio->slug));
    }
}
