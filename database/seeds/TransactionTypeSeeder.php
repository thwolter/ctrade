<?php

use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entities\TransactionType::firstOrCreate(['code' => 'buy','name' => 'Kauf']);
        \App\Entities\TransactionType::firstOrCreate(['code' => 'sell','name' => 'Verkauf']);
        \App\Entities\TransactionType::firstOrCreate(['code' => 'deposit','name' => 'Einzahlung']);
        \App\Entities\TransactionType::firstOrCreate(['code' => 'withdraw','name' => 'Auszahlung']);
    }
}
