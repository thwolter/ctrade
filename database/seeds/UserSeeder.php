<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::firstOrCreate([
            'name' => 'examples',
            'email' => 'thwolter@web.de',
            'password' => bcrypt('examples'),
            'verified' => true
        ]);

        User::firstOrCreate([
            'name' => 'Thomas Wolter',
            'email' => 'thwolter@gmail.com',
            'password' => bcrypt('123'),
            'verified' => true
        ])->assignRole('admin');
    }
}
