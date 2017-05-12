<?php

namespace Tests\Unit\Repos\Metadata;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuandlECBTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->meta->loadDatabase('ECB');
        $this->assertTrue(true);
    }
}
