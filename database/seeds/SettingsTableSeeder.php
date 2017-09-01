<?php

namespace Backpack\Settings\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'           => 'contact_email',
            'name'          => 'Contact form email address',
            'description'   => '',
            'value'         => 'info@capmyrisk.com',
            'field'         => '{"name":"value","label":"Value","type":"email"}',
            'active'        => 1,
        ],
        [
            'key'           => 'admin_email',
            'name'          => 'Admin email address',
            'description'   => 'Notification will be send to this adress.',
            'value'         => 'thwolter@gmail.com',
            'field'         => '{"name":"value","label":"Value","type":"email"}',
            'active'        => 1,
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted '.count($this->settings).' records.');
    }
}
