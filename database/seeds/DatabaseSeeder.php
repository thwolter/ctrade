<?php

use Illuminate\Database\Seeder;
use Backpack\Settings\database\seeds\SettingsTableSeeder;
use Illuminate\Support\Facades\App;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(LanguageTableSeeder::class);

        $this->dev();
    }

    private function dev()
    {
        if (! App::environment('production')) {
            $this->call(UserSeeder::class);
        }
    }
}
