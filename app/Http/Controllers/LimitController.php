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
        $portfolio = Portfolio::findOrFail($request->id)->first();
        $repo = new LimitRepository($portfolio);

        $success = [];
        foreach (LimitType::all() as $type) {

            if ($request->exists($type->code)) {
                $success[] = $repo->set($type->code, $request->all());

            } else {
                $repo->inactivate($type->code);
            }
        }

        session(['active_tab' => $request->active_tab]);
        $redirect = redirect(route('portfolios.edit', $portfolio->slug));

        if (array_search(false, $success)) {
            return $redirect->with('error', 'Limite konnten nicht angepasst werden. Bitte überprüfe die Werte.');

        } else {
            return $redirect->with('success', 'Limite erfolgreich geändert.');
        }
    }
}
