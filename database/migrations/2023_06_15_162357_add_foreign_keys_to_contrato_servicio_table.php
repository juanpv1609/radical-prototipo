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
        Schema::table('contrato_servicio', function (Blueprint $table) {
            $table->foreign(['servicio_id'], 'FK_contratos_servicios_servicios')->references(['id'])->on('servicios');
            $table->foreign(['contrato_id'], 'FK_contratos_servicios_contratos')->references(['id'])->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato_servicio', function (Blueprint $table) {
            $table->dropForeign('FK_contratos_servicios_servicios');
            $table->dropForeign('FK_contratos_servicios_contratos');
        });
    }
};
