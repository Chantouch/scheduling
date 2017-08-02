<?php

namespace App\Console;

use App\Console\Commands\SyncGoogleCalendar;
use App\Console\Commands\SyncMeetingData;
use App\Console\Commands\SyncMissionData;
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
        SyncGoogleCalendar::class,
        SyncMeetingData::class,
        SyncMissionData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('google:sync')
            ->everyMinute();
        $schedule->command('sync:meetings')
            ->everyMinute();
        $schedule->command('sync:missions')
            ->everyMinute();
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
