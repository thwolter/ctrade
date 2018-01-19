<?php



Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '0',
        'redirect_uri' => 'http://ctrade.cev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://ctrade.dev/oauth/authorize?'.$query);
});


Route::get('/success', function() {
    return view('auth.success');
});

Route::get('/verified', function() {
    return view('auth.confirmed.email');
});
