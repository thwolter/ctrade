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
        \App\Entities\TransactionType::firstOrCreate(['code' => 'trade','name' => 'trade']);
        \App\Entities\TransactionType::firstOrCreate(['code' => 'payment','name' => 'payment']);
    }
}
