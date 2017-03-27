<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PortfoliosBrowserTest extends DuskTestCase
{

    use DatabaseMigrations;


    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }


    public function testUserCanCreatePortfolio()
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)
                ->visit('/portfolios/create')
                ->type('name', 'A New Portfolio')
                ->type('currency', 'EUR')
                ->press('Erstellen');
        });

        $this->assertDatabaseHas('portfolios', [
            'name'=>'A New Portfolio',
            'currency'=>'EUR'
        ]);
    }



}
