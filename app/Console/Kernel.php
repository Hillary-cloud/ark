<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:update-expired-ads')->dailyAt('00:00');

        // New scheduled task for ad expiration notifications
        $schedule->command('ads:send-expiration-notifications')->dailyAt('01:00');

        $schedule->command('backup:clean')->daily()->at('03:00'); // Comment out or remove this line
        $schedule->command('backup:run')->daily()->at('04:00');   // Create a new backup daily

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
