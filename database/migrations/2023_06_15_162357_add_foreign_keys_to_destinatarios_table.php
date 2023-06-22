<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('destinatarios', function (Blueprint $table) {
            $table->foreign(['contrato_id'], 'FK_destinatarios_contratos')->references(['id'])->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('destinatarios', function (Blueprint $table) {
            $table->dropForeign('FK_destinatarios_contratos');
        });
    }
};
