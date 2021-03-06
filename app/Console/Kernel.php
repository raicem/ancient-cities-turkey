<?php

namespace App\Console;

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
        Commands\CheckLinks::class,
        Commands\GenerateSitemap::class,
        Commands\GetCitiesFromCoordinates::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')->weekly()->fridays()->at('19:00');
        $schedule->command('links:check')->weekly()->fridays()->at('20:00');
        // $schedule->command('backup:clean')->weekly()->fridays()->at('21:00');
        // $schedule->command('backup:run')->weekly()->fridays()->at('22:00');
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
