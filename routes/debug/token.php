<?php



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
