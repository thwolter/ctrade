<?php

namespace App\Console;

use App\Console\Commands\Metadata\UpdateMetadata;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DeleteTemp::class,

        Commands\Metadata\UpdateMetadata::class,
        Commands\Metadata\CheckMetadata::class,

        Commands\TestMail::class,

        Commands\Calculations\CalculateRisk::class,
        Commands\Calculations\CalculateValue::class,
        Commands\CheckLimits::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();

        $schedule->command(UpdateMetadata::class)->daily('23:00');

        //$schedule->command(CalcPortfolioValue::class)->daily('01:00');
        //$schedule->command(CalcPortfolioRisk::class)->daily('01:30');

        $schedule->command('backup:clean')->daily()->at('04:00');
        $schedule->command('backup:run')->daily()->at('05:00');


    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
