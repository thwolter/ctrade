<?php

namespace App\Http\Controllers;

use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Repositories\LimitRepository;
use Illuminate\Http\Request;

class LimitController extends Controller
{

    public function set(Request $request)
   {
       $portfolio = Portfolio::findOrFail($request->id)->first();
       $repo = new LimitRepository($portfolio);

       foreach (LimitType::all() as $type) {

           if ($request->exists($type->code)) {
               $success = $repo->set($type->code, $request->all());

           } else {
               $repo->inactivate($type->code);
           }
       }

       if ($success) {
           return redirect(route('portfolios.edit', $request->id))
               ->with('message', 'Limite erfolgreich geändert.')
               ->with('active', $request->active);
       } else {
           return redirect(route('portfolios.edit', $request->id))
               ->with('error', 'Limite konnten nicht angepasst werden. Bitte überprüfe die Werte.')
               ->with('active', $request->active);
       }
   }
}
