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


    public function test_user_can_create_portfolio()
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


    public function test_user_can_edit_portfolio()
    {
        $portfolio = factory('App\Portfolio')->create(['user_id' => $this->user->id]);

        $this->browse(function ($browser) use ($portfolio) {

            $browser->loginAs($this->user)
                ->visit('/portfolios/'.$portfolio->id.'/edit')
                ->type('name', 'This is a changed portfolio name')
                ->type('currency', 'NEW')
                ->press('Ändern');
        });

        $this->assertDatabaseHas('portfolios', [
            'name' => 'This is a changed portfolio name',
            'currency' => 'NEW'
        ]);
    }


    public function test_user_can_delete_portfolio()
    {
        $portfolio = factory('App\Portfolio')->create(['user_id' => $this->user->id]);

        $this->browse(function ($browser) use ($portfolio) {

            $browser->loginAs($this->user)
                ->visit('/portfolios/'.$portfolio->id)
                ->press('Löschen');
        });

        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }



}
