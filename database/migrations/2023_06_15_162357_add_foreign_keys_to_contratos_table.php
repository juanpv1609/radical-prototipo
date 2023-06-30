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
        Schema::table('contratos', function (Blueprint $table) {
            $table->foreign(['cliente_id'], 'FK_contratos_clientes')->references(['id'])->on('clientes');
            $table->foreign(['area_id'], 'FK_contratos_areas')->references(['id'])->on('areas');
            $table->foreign(['pais_id'], 'FK_contratos_paises')->references(['id'])->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign('FK_contratos_clientes');
            $table->dropForeign('FK_contratos_areas');
            $table->dropForeign('FK_contratos_paises');
        });
    }
};
