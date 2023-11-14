<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contrato;
use App\Models\Destinatario;
use App\Models\ContratoDestinatario;


class AddresseeContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:addresseeContract';

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
        $contratos = Contrato::all();

        $destinatarios = Destinatario::where('is_deleted',0)->get();

        foreach ($contratos as $contrato) {
            foreach ($destinatarios as $destinatario) {
                $contratoDestinatario = new ContratoDestinatario([
                    'contrato_id' => $contrato->id,
                    'destinatario_id' => $destinatario->id,
                    'estado' => 1,
                    'is_deleted' => 0
                ]);

                $contratoDestinatario->save();
            }
        }
        $this->info('Successfully sent daily quote to everyone.');
    }
}
