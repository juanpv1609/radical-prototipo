<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToContratoDestinatario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrato_destinatario', function (Blueprint $table) {
        
            $table->foreign(['contrato_id'], 'FK_contratos_destinatarios_contratos')->references(['id'])->on('contratos');
            $table->foreign(['destinatario_id'], 'FK_contratos_destinatarios_destinatarios')->references(['id'])->on('destinatarios');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato_destinatario', function (Blueprint $table) {

            $table->dropForeign('FK_contratos_destinatarios_contratos');
            $table->dropForeign('FK_contratos_destinatarios_destinatarios');
        });
    }
}
