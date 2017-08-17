<?php

namespace Tests\Browser;

use App\Entities\Taker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TakerTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $email;


    public function setUp()
    {
        parent::setUp();

        $this->email = 'thwolter@web.de';
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_subscribe()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/launch')
                ->type('email', $this->email)
                ->press('subscribe')
                ->pause(10000)
                ->assertSee('erfolgreich');
        });
    }

    public function test_validate()
    {
        $email = $this->email;
        $token = Taker::whereEmail($this->email)->first()->email_token;

        $this->browse(function (Browser $browser) use ($token, $email) {
            $browser->visit('/verify/'.$token)
                ->assertSee($email);
        });


    }
}
