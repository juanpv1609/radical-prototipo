<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Tareas;
use App\Mail\TareasEmail;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\SendAlert;
use Illuminate\Support\Facades\Mail;
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
        Commands\SendAlert::class,
        //Commands\SendAlertWeek::class,
        'App\Console\Commands\DatabaseBackUp'
    ];
    protected function scheduleTimezone()
    {
        return 'America/Guayaquil';
    }
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:alert')
        ->dailyAt('07:00');
        $schedule->command('send:alert2')
        ->dailyAt('07:00');
        //$schedule->command('send:alertp')
        //->hourly();
        $schedule->command('send:alertendcontract30')
        ->dailyAt('07:00');
        $schedule->command('send:alertendcontract15')
        ->dailyAt('07:00');
        $schedule->command('send:alertendcontract7')
        ->dailyAt('07:00');
        //$schedule->command('send:alert_week')
        //->dailyAt('07:00');

        $schedule->command('database:backup')
        ->dailyAt('07:00');

        /* $schedule->command('theTask')
        ->weekly()
        ->mondays()
         ->at('12:30'); */


        //->twiceDaily(7, 13);
         //->everyMinute();
        //->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
