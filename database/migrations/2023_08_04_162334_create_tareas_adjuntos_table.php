<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas_adjuntos', function (Blueprint $table) {
            $table->id('id', true);
            $table->unsignedBigInteger('tarea_id')->default(0)->index('FK_tareas_adjuntos_tareas');
            $table->integer('version')->default(0);
            $table->longText('adjunto')->nullable();
            $table->longText('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas_adjuntos');
    }
}
