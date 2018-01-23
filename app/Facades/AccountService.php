<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class AccountService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'accountService';
    }
}