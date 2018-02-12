<?php

use App\Entities\Stock;
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

        $this->createAsset1($portfolio);
        $this->createAsset2($portfolio);

        $this->createLimits($portfolio);
    }

    /**
     * Create and persist a Portfolio.
     *
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
     * Create and persist an asset.
     *
     * @param $portfolio
     */
    private function createAsset1($portfolio)
    {
        TransactionService::trade($portfolio, [
            'instrumentType' => Stock::class,
            'instrumentId' => 88,
            'transaction' => 'settlement',
            'amount' => 100,
            'price' => '60',
            'fee' => 19.50,
            'exchange' => 'Xetra',
            'executed' => '2017-12-05'
        ]);

        TransactionService::trade($portfolio, [
            'instrumentType' => Stock::class,
            'instrumentId' => 88,
            'transaction' => 'settlement',
            'amount' => 10,
            'price' => '70',
            'fee' => 19.50,
            'exchange' => 'Xetra',
            'executed' => '2017-12-15'
        ]);

        TransactionService::trade($portfolio, [
            'instrumentType' => Stock::class,
            'instrumentId' => 88,
            'transaction' => 'settlement',
            'amount' => -10,
            'price' => '65',
            'fee' => 19.50,
            'exchange' => 'Xetra',
            'executed' => '2017-12-20'
        ]);
    }

    /**
     * Create and persist an asset.
     *
     * @param $portfolio
     */
    private function createAsset2($portfolio): void
    {
        TransactionService::trade($portfolio, [
            'instrumentType' => Stock::class,
            'instrumentId' => 91,
            'transaction' => 'settlement',
            'amount' => 50,
            'price' => '66',
            'fee' => 0,
            'exchange' => 'Xetra',
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
