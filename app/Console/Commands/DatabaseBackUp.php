<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\BackupEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (Carbon::now()->dayOfWeek == Carbon::MONDAY) {
            $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
            $command = "".env('DUMP_PATH')." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backup/" . $filename;
            $returnVar = null;
            $output = null;
            exec($command, $output, $returnVar);
            $details=[
            'title' => 'Ejecución automática de backup diario',
            'body' => 'Estimad@ el software <strong>RGSDM</strong> ha generado el backup diario automático correspondiente al '.Carbon::now()->format('Y-m-d'),
            'file' =>  $filename
        ];
            Mail::to('juan.perugachi@gruporadical.com')
                    //->cc(['paul.canchignia@gruporadical.com','xavier.montoya@gruporadical.com'])
                    ->send(new BackupEmail($details));
                    $this->info('Emails enviados.');

        }else{
            $this->info('Emails NO enviados.');


        }

    }
}
