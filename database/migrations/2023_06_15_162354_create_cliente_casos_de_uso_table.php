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
        Schema::create('cliente_casos_de_uso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('cliente_id')->default(0)->index('FK__clientes');
            $table->integer('caso_de_uso_id')->index('FK__casos_de_uso');
            $table->longText('resultado_esperado')->nullable();
            $table->longText('escenario')->nullable();
            $table->integer('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_casos_de_uso');
    }
};
