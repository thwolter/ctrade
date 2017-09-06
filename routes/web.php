<?php


foreach (File::allFiles(__DIR__.'/app') as $partial)
{
    require_once $partial->getPathname();
}




