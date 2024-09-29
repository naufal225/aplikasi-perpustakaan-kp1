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
        $schedule->call(function(): void {
            app(abstract: \App\Http\Controllers\TransaksiPinjamController::class)->updateStatus();
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(paths: __DIR__.'/Commands');

        require base_path(path: 'routes/console.php');
    }

    protected function scheduleTimezone(): string
    {
        return 'Asia/Jakarta';
    }
}
