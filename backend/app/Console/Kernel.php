<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register your command here
        \App\Console\Commands\CheckLikesThreshold::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Run the likes threshold check daily at 8 AM
        $schedule->command('likes:check-threshold')->dailyAt('08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
