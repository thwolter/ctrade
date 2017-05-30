<?php

namespace Tests\Unit\Models;

use App\Models\Pathway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PathwayTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function converts_into_a_string()
    {
        Pathway::make('Quandl', 'SSE', 'ALV')->save();
        $string1 = Pathway::withDatasetCode('ALV')->first()->string();
        $string2 = (string)Pathway::withDatasetCode('ALV')->first();

        $this->assertEquals('Quandl.SSE.ALV', $string1);
        $this->assertEquals('Quandl.SSE.ALV', $string2);
    }
}
