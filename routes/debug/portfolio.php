<?php


use Illuminate\Support\Facades\Artisan;



Route::get('{portfolio}/fire', function(\App\Entities\Portfolio $portfolio) {
    $object = new \App\Jobs\Calculations\CalculationObject($portfolio, 'risk');
    event(new \App\Events\CalculationStatusUpdate($object));
});

Route::get('portfolio/index', function() {
    redirect('http://ctrade.dev/portfolio')->with('success', 'hi, it works');
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

