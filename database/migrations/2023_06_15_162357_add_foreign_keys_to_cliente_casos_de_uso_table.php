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
        Schema::table('cliente_casos_de_uso', function (Blueprint $table) {
            $table->foreign(['cliente_id'], 'FK__clientes')->references(['id'])->on('clientes');
            $table->foreign(['caso_de_uso_id'], 'FK__casos_de_uso')->references(['id'])->on('casos_de_uso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cliente_casos_de_uso', function (Blueprint $table) {
            $table->dropForeign('FK__clientes');
            $table->dropForeign('FK__casos_de_uso');
        });
    }
};
