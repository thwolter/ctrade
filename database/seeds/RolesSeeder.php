<?php

use Illuminate\Database\Seeder;
use Backpack\PermissionManager\app\Models\Role;

class RolesSeeder extends Seeder
{

    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tester']);
        Role::create(['name' => 'taker']);
    }
}
