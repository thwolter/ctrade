<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Facades\Repositories\PortfolioRepository;
use App\Facades\TransactionService;

class PortfolioSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereLastName('Wolter')->first();

        $portfolio = $this->createPortfolio($user);

        $this->createPositions($portfolio);

        $this->createLimits($portfolio);
    }

    /**
     * @param $user
     * @return mixed
     */
    private function createPortfolio($user)
    {
        return PortfolioRepository::createPortfolio($user, [
            'name' => 'Test Portfolio',
            'date' => '2017-12-01',
            'description' => 'Portfolio for development testing.',
            'currency' => 1,
        ]);
    }

    /**
     * @param $portfolio
     */
    private function createPositions($portfolio): void
    {
        TransactionService::trade($portfolio, [
            'instrumentType' => \App\Entities\Stock::class,
            'instrumentId' => 88,
            'transaction' => 'buy',
            'amount' => 100,
            'price' => '20',
            'fees' => 19.50,
            'executed' => '2017-12-05'
        ]);

        TransactionService::trade($portfolio, [
            'instrumentType' => \App\Entities\Stock::class,
            'instrumentId' => 91,
            'transaction' => 'buy',
            'amount' => 50,
            'price' => '66',
            'fees' => 0,
            'executed' => '2017-12-10'
        ]);
    }

    /**
     * @param $portfolio
     */
    private function createLimits($portfolio)
    {
        $portfolio->limits()->create([
            'type' => 'absolute',
            'value' => 1200,
            'date' => '2017-12-15'
        ]);
    }
}
