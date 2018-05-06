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
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * * * * * * php /opt/work/loginfo/artisan schedule:run >> /dev/null 2>&1
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     *
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('logsinfo:send --t apachelog')->dailyAt("22:00");
        $schedule->command('logsinfo:send --t syslog')->dailyAt("23:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
