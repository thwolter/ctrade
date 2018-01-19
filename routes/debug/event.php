<?php



Route::get('event', function(Request $request) {
    $limit = \App\Entities\Limit::firstOrFail();
    event(new \App\Events\Limits\LimitHasChanged($limit));
});
