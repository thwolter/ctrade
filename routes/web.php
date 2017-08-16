<?php


foreach (File::allFiles(__DIR__.'/app') as $partial)
{
    require_once $partial->getPathname();
}


App::bind(
    'App\Repositories\Contracts\InstrumentInterface',
    'App\Repositories\InstrumentRepository'
);

Route::get('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout');
Route::get('admin/register', 'Auth\RegisterController@register');

