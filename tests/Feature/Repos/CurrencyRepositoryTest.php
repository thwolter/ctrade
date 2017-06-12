<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\CurrencyRepository;

class CurrencyRepositoryTest extends TestCase
{
    
    public function setUp()
    {
        parent::setUp();
        
    }
    
    public function testExample()
    {
        $ccyRepo = new CurrencyRepository('EUR', 'USD');
        $this->assertTrue(true);
    }
}
