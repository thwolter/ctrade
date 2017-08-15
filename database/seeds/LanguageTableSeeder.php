<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name'        => 'English',
            'app_name'    => 'english',
            'flag'        => '',
            'abbr'        => 'en',
            'script'    => 'Latn',
            'native'    => 'English',
            'active'    => '1',
            'default'    => '1',
        ]);

        DB::table('languages')->insert([
            'name'        => 'German',
            'app_name'    => 'german',
            'flag'        => '',
            'abbr'        => 'de',
            'script'    => 'Latn',
            'native'    => 'Deutsch',
            'active'    => '0',
            'default'    => '0',
        ]);

        $this->command->info('Language seeding successful.');
    }
}
