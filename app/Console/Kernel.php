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
        //
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

        $schedule->command('horizon:snapshot')->everyFiveMinutes();


    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');

        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/Commands/Calculations');
        $this->load(__DIR__.'/Commands/Metadata');
        $this->load(__DIR__.'/Commands/Rscript');
    }
}
