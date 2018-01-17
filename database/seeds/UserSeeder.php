<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class UserSeeder extends Seeder
{

    public function run()
    {

        User::firstOrCreate([
            'last_name' => 'webmaster',
            'email' => 'webmaster@capmyrisk.com',
            'password' => bcrypt('123'),
            'verified' => true
        ]);

        User::firstOrCreate([
            'first_name' => 'Thomas',
            'last_name' => 'Wolter',
            'email' => 'thwolter@gmail.com',
            'password' => bcrypt('123'),
            'verified' => true
        ])->assignRole('admin');
    }
}
