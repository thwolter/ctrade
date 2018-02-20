<?php

namespace Tests\Feature\Controller;

use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioControllerTest extends TestCase
{

    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan("db:Seed");
        $this->artisan('metadata:update');

        $this->user = User::whereEmail('thwolter@gmail.com')->first();
    }

    public function test_index()
   {
       $response = $this->actingAs($this->user)->get(route('portfolios.index'));
       $response->assertStatus(200);
   }
}
