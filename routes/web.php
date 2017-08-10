<?php


foreach (File::allFiles(__DIR__.'/app') as $partial)
{
    require_once $partial->getPathname();
}


App::bind(
    'App\Repositories\Contracts\InstrumentInterface',
    'App\Repositories\InstrumentRepository'
);

Route::get('/rollback/{id}/{date}', function($id, $date) {
    $portfolio = \App\Entities\Portfolio::find($id);
    $portfolio->rollbackToDate($date);
});

Route::get('/index', function() {
    return view('layouts.master');
});

Route::get('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout');
Route::get('admin/register', 'Auth\RegisterController@register');
