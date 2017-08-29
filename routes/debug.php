<?php

use Illuminate\Support\Facades\Artisan;


Route::get('test', function() {
    return view('auth.confirmed.email', ['user' => \App\Entities\User::first()]);
});


Route::get('event', function(Request $request) {
    $limit = \App\Entities\Limit::firstOrFail();
    event(new \App\Events\Limits\LimitHasChanged($limit));
});

Route::get('metadata/update', function() { Artisan::call('metadata:update'); });

Route::get('temp/delete', function() { Artisan::call('temp:delete'); });

Route::get('calculate/risk', function() { Artisan::call('calculate:risk'); });
Route::get('calculate/value', function() { Artisan::call('calculate:value'); });

Route::get('quandl/{database}/{symbol}', function($database, $symbol) {
    Artisan::call('metadata:check', [
        'provider' => 'Quandl', 'database' => $database, 'symbol' => $symbol
    ]);
});

Route::get('template', function() {
    return view('test');
});

Route::get('portfolio/{id}', function($id) {
    return redirect('api/portfolio', $id);
});

Route::get('token', function() {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('http://ctrade.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '1',
            'client_secret' => '22zGlADqbdaftoHulePLDrZBVM8eo8FD4GGocBYt',
            'scope' => '',
        ],
    ]);

    //return $response->access_token;
    return json_decode((string) $response->getBody(), true);
});


Route::get('token2', function() {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('//capmyrisk.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '3',
            'client_secret' => '7TjmuPRaaCm5EqeV6mYlM8tB3bGvc99rpY1Z3EfA',
            'scope' => '',
        ],
    ]);

    //return $response->access_token;
    return json_decode((string) $response->getBody(), true);
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'ctrade.dev/callback',
        'response_type' => 'token',
        'scope' => '',
    ]);

    return redirect('oauth/authorize?'.$query);
});