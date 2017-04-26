<?php

namespace Tests\Unit\tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Oanda\OandaFinancial;

class OandaFinancialTest extends TestCase
{
    
    public function test_EURUSD_has_history()
    {
        $data = OandaFinancial::make()->history("EURUSD");
        
    }
}
