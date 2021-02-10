<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Tareas;
use App\Mail\TareasEmail;
use Illuminate\Support\Facades\DB;
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
        //
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

        $schedule->call(function () {


            $alerta_fechas = Tareas::with('contrato.cliente', 'frecuencias','estado_tarea','tipo','usuario')
                            ->whereRaw('fecha_alerta = curdate()')->get();
                foreach ($alerta_fechas as $item) {
                    $details = [

                    'title' => 'Notificacion de alerta',
                    'body' => 'Se ha disparado la siguiente alerta',
                    'cliente' => $item->contrato->cliente->razon_social,
                    'fecha_entrega' => $item->fecha,
                    'tipo_tarea' => $item->tipo->nombre

                    ];
                    Mail::to($item->usuario->email)->send(new TareasEmail($details));

                }
        })->timezone('America/Guayaquil')->everyMinute();
        //->dailyAt('07:00');
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
