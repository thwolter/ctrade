<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class TransactionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'transactionService';
    }
}