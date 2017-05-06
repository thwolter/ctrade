<?php

namespace Tests\Unit\Entities;

use App\Entities\Sector;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SectorTest extends TestCase
{
    use DatabaseMigrations;

    protected $sector = 'Example Sector';


    public function test_can_create_sector()
    {
        factory(Sector::class)->create(['name' => $this->sector]);
        $sector = Sector::where('name', $this->sector)->first()->name;
        $this->assertEquals($this->sector, $sector);
    }
}
