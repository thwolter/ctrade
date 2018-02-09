<?php

namespace Tests\Feature;

use App\Entities\Asset;
use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Exchange;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Provider;
use App\Entities\Stock;
use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user_model()
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }


    public function test_can_create_ccyPair_model()
    {
        $ccyPair = factory(CcyPair::class)->create();
        $this->assertDatabaseHas('ccy_pairs', ['id' => $ccyPair->id]);
    }


    public function test_can_create_currency_model()
    {
        $currency = factory(Currency::class)->create();
        $this->assertDatabaseHas('currencies', ['id' => $currency->id]);
    }


    public function test_can_create_currency_model_with_code_states()
    {
        factory(Currency::class)->states('USD')->create();
        $this->assertDatabaseHas('currencies', ['code' => 'USD']);

        factory(Currency::class)->states('CZK')->create();
        $this->assertDatabaseHas('currencies', ['code' => 'CZK']);

        factory(Currency::class)->states('EUR')->create();
        $this->assertDatabaseHas('currencies', ['code' => 'EUR']);
    }


    public function test_can_create_currency_model_with_eligible_states()
    {
        factory(Currency::class)->states('eligible')->create();
        $this->assertDatabaseHas('currencies', ['eligible' => 1]);
    }


    public function test_can_create_exchange_model()
    {
        $exchange = factory(Exchange::class)->create();
        $this->assertDatabaseHas('exchanges', ['id' => $exchange->id]);
    }


    public function test_can_create_portfolio_model()
    {
        $portfolio = factory(Portfolio::class)->create();
        $this->assertDatabaseHas('portfolios', ['id' => $portfolio->id]);
    }


    public function test_can_create_portfolio_model_with_currency_states()
    {
        $portfolio = factory(Portfolio::class)->states('USD')->create();
        $this->assertDatabaseHas('portfolios', ['currency_id' => $portfolio->currency->id]);

        $portfolio = factory(Portfolio::class)->states('EUR')->create();
        $this->assertDatabaseHas('portfolios', ['currency_id' => $portfolio->currency->id]);
    }


    public function test_can_create_asset_model()
    {
        $asset = factory(Asset::class)->create();
        $this->assertDatabaseHas('assets', ['id' => $asset->id]);
    }


    public function test_can_create_asset_with_currency_states()
    {
        $asset = factory(Asset::class)->states('USD')->create();
        $this->assertEquals('USD', $asset->positionable->currency->code);

        $asset = factory(Asset::class)->states('EUR')->create();
        $this->assertEquals('EUR', $asset->positionable->currency->code);
    }


    public function test_can_create_position_model()
    {
        $position = factory(Position::class)->create();
        $this->assertDatabaseHas('positions', ['id' => $position->id]);
    }


    public function test_created_position_is_executed_after_portfolio_opened()
    {
        $position = factory(Position::class)->create();
        $this->assertGreaterThan($position->asset->portfolio->opened_at, $position->executed_at);
    }


    public function test_created_position_has_stock()
    {
        $position = factory(Position::class)->create();
        $this->assertEquals(Stock::class, get_class($position->asset->positionable));
    }


    public function test_can_create_position_with_currency_states()
    {
        $position = factory(Position::class)->states('USD')->create();
        $this->assertEquals('USD', $position->asset->positionable->currency->code);

        $position = factory(Position::class)->states('EUR')->create();
        $this->assertEquals('EUR', $position->asset->positionable->currency->code);
    }


    public function test_can_create_stock_model()
    {
        $stock = factory(Stock::class)->create();
        $this->assertDatabaseHas('stocks', ['id' => $stock->id]);
    }


    public function test_can_create_stock_with_currency_states()
    {
        $stock = factory(Stock::class)->states('USD')->create();
        $this->assertEquals('USD', $stock->currency->code);

        $stock = factory(Stock::class)->states('EUR')->create();
        $this->assertEquals('EUR', $stock->currency->code);
    }


    public function test_can_create_dataset_model()
    {
        $dataset = factory(Dataset::class)->create();
        $this->assertDatabaseHas('datasets', ['id' => $dataset->id]);

        $dataset = factory(Dataset::class)->states('currency')->create();
        $this->assertDatabaseHas('datasets', ['code' => $dataset->code]);

        $dataset = factory(Dataset::class)->states('stock')->create();
        $this->assertDatabaseHas('datasets', ['code' => $dataset->code]);
    }


    public function test_can_create_provider_model()
    {
        $provider = factory(Provider::class)->create();
        $this->assertDatabaseHas('providers', ['id' => $provider->id]);
    }


    public function test_can_create_database_model()
    {
        $database = factory(Database::class)->create();
        $this->assertDatabaseHas('databases', ['id' => $database->id]);
    }


    public function test_can_create_datasource_model()
    {
        $datasource = factory(Datasource::class)->create();
        $this->assertDatabaseHas('datasources', ['id' => $datasource->id]);

        $datasource = factory(Datasource::class)->states('USD')->create();
        $this->assertDatabaseHas('datasources', ['id' => $datasource->id]);

        $datasource = factory(Datasource::class)->states('CHF')->create();
        $this->assertDatabaseHas('datasources', ['id' => $datasource->id]);

        $datasource = factory(Datasource::class)->states('stock')->create();
        $this->assertDatabaseHas('datasources', ['id' => $datasource->id]);

        $datasource = factory(Datasource::class)->states('Quandl')->create();
        $this->assertDatabaseHas('datasources', ['id' => $datasource->id]);
    }
}
