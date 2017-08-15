<?php

namespace App\Console;

use App\Console\Commands\CacheQuandlSSE;
use App\Console\Commands\CalculateRisk;
use App\Console\Commands\UpdateMetadata;
use App\Console\Commands\UpdateQuandlSSE;
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
        Commands\UpdateMetadata::class,
        Commands\TestMail::class,
        Commands\CalculateRisk::class,
        Commands\CalculateValue::class,
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
        $schedule->command(UpdateMetadata::class)->hourly();

        $schedule->command('backup:clean')->daily()->at('04:00');
        $schedule->command('backup:run')->daily()->at('05:00');

        $schedule->command('inspire')->everyMinute();
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
