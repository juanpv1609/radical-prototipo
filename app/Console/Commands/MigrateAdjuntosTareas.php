<?php

namespace App\Console\Commands;

use App\Models\TareaAdjunto;
use App\Models\Tareas;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MigrateAdjuntosTareas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:attachmentsTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate attachments from the tasks table to the attachments table associated with tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tareasConAdjuntos = Tareas::get();

        foreach($tareasConAdjuntos as $tarea)
        {
            TareaAdjunto::created([
                'tarea_id' => $tarea->id,
                'version' => 0,
                'adjunto' => $tarea->adjunto,
                'observación' => $tarea->observacion,
            ]);
        }

        $this->info('Migración de adjuntos completa');
    }   
}
