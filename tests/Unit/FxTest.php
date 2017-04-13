<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Library\Yahoo\FxData;

class FxTest extends TestCase
{

    public function test_currency_is_a_number()
    {
        $fx = new FxData('EURUSD');
        $this->assertGreaterThan(0, $fx->Rate);
    }
}
