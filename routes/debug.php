<?php


if (App::isLocal()) {

    foreach (File::allFiles(__DIR__.'/debug') as $partial)
    {
        require_once $partial->getPathname();
    }
}







