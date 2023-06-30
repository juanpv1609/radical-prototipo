<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->integer('contrato_id');
            $table->integer('frecuencia');
            $table->integer('tipo_tarea');
            $table->integer('dia_elegido');
            $table->string('ticket', 20);
            $table->integer('responsable');
            $table->date('fecha');
            $table->date('fecha_alerta');
            $table->integer('alerta');
            $table->string('adjunto', 200);
            $table->string('observacion', 200);
            $table->integer('estado');
            $table->timestamps();
            //$table->foreign('contrato_id')->references('id')->on('contratos');
            //$table->foreign('frecuencia')->references('id')->on('frecuencias');
            //$table->foreign('tipo_tarea')->references('id')->on('tipo_tarea');
            //$table->foreign('responsable')->references('id')->on('users');
            //$table->foreign('estado')->references('id')->on('estado_tareas');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
