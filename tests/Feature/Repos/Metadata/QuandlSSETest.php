<?php

namespace Tests\Feature\Repos\Metadata;

use App\Entities\Dataset;
use App\Entities\Stock;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\QuandlSSE;


class QuandlSSETest extends TestCase
{
    use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new QuandlSSE(new ConsoleOutput());
        $this->artisan('db:seed', ['--class' => 'CurrencySeeder']);
    }

    /** @test */
    public function can_load_data()
    {
        $this->meta->load();

        $this->assertEquals(5, count(Stock::all()));

    }


}
