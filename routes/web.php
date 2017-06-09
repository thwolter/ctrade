<?php


foreach (File::allFiles(__DIR__.'/app') as $partial)
{
    require_once $partial->getPathname();
}


App::bind(
    'App\Repositories\Contracts\InstrumentInterface',
    'App\Repositories\InstrumentRepository'
);