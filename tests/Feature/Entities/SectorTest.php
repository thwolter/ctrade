<?php

namespace Tests\Feature\Entities;

use App\Entities\Sector;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SectorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_create_sector()
    {
        factory(Sector::class)->create(['name' => 'Example Sector']);
        
        $this->assertEquals('Example Sector', Sector::whereName('Example Sector')->first()->name);
    }
}
