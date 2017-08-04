<?php

use Illuminate\Database\Seeder;
use App\Entities\LimitType;


class LimitTypeSeeder extends Seeder
{

    public function run()
    {
        LimitType::firstOrCreate(['code' => 'absolute', 'name' => 'Absolut Limit']);
        LimitType::firstOrCreate(['code' => 'relative', 'name' => 'Relative Limit']);
        LimitType::firstOrCreate(['code' => 'floor', 'name' => 'Floor Limit']);
        LimitType::firstOrCreate(['code' => 'target', 'name' => 'Target Limit']);
    }
}
