<?php

use Illuminate\Support\Facades\Artisan;

Route::get('phpinfo', function() {
    phpinfo();
});

Route::get('test', function() {
    return App\Entities\CcyPair::whereSymbol('EURUSD')->first()->price();
});

Route::get('portfolio/index', function() {
   redirect('http://ctrade.dev/portfolio')->with('success', 'hi, it works');
});

Route::get('event', function(Request $request) {
    $limit = \App\Entities\Limit::firstOrFail();
    event(new \App\Events\Limits\LimitHasChanged($limit));
});

Route::get('metadata/update/{database}', function($database) {
    Artisan::call('metadata:update', ['database' => $database]);
});

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

    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('http://ctrade.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '3',
            'client_secret' => 'wqRd8pd1kHDKwwDAi5TxTQNSSdot88NujG43VUyG',
            'scope' => '*',
        ],
    ]);

    $json = json_decode((string)$response->getBody(), true);
    $token = $json['access_token'];

    $guzzle = new GuzzleHttp\Client;
    $response = $guzzle->get('http://ctrade.dev/api/portfolio?id=1', [
        //'query' => 'id='.$id,
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ],
    ]);

    return $response;
});



Route::get('token', function() {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('http://ctrade.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '1',
            'client_secret' => '22zGlADqbdaftoHulePLDrZBVM8eo8FD4GGocBYt',
            'scope' => '*',
        ],
    ]);

    //return $response->access_token;
    return json_decode((string) $response->getBody(), true);
});



Route::get('token2', function() {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('https://www.capmyrisk.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => '3',
            'client_secret' => 'AAOmHxG4Jvf8quf9IzMiL995Y6cSpBhd6jJAdncf',
            'scope' => '',
        ],
    ]);

    //return $response->access_token;
    return json_decode((string) $response->getBody(), true);
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '0',
        'redirect_uri' => 'http://ctrade.cev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://ctrade.dev/oauth/authorize?'.$query);
});

Route::get('/update/stocks', function() {

    foreach (\App\Entities\Stock::all() as $stock) {

        if (! $stock->datasources) {
            $a = $stock->id;
        }

    }
});

Route::get('/success', function() {
    return view('auth.success');
});