<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('descrcipcion', 200);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('cliente_id');
            $table->integer('pais_id');
            $table->integer('area_id');
            $table->string('solucion', 200);
            $table->string('marca', 200);
            $table->longText('correos');
            $table->string('observacion', 200);
            $table->integer('estado');
            $table->timestamps();
            //$table->foreign('cliente_id')->references('id')->on('clientes');
            //$table->foreign('pais_id')->references('id')->on('paises');
            //$table->foreign('area_id')->references('id')->on('areas');
            //$table->foreign('estado')->references('id')->on('estado_contratos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
