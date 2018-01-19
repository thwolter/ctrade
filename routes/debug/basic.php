<?php


Route::get('phpinfo', function() {
    phpinfo();
});


Route::get('temp/delete', function() { Artisan::call('temp:delete'); });


Route::get('template', function() {
    return view('test');
});
