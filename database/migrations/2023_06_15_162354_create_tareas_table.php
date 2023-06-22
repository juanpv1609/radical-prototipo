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
        Schema::create('tareas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('descripcion')->nullable();
            $table->unsignedBigInteger('contrato_id')->default(0);
            $table->integer('frecuencia');
            $table->integer('tipo_tarea');
            $table->integer('dia_elegido');
            $table->string('ticket', 20)->nullable();
            $table->integer('responsable');
            $table->date('fecha');
            $table->date('fecha_alerta');
            $table->integer('alerta');
            $table->longText('adjunto')->nullable();
            $table->longText('observacion')->nullable();
            $table->integer('estado');
            $table->smallInteger('alerta_enviada')->nullable()->default(0);
            $table->smallInteger('segunda_alerta_enviada')->nullable()->default(0);
            $table->smallInteger('cuenta_alertas')->nullable()->default(0);
            $table->longText('correos_alerta')->nullable();
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
        Schema::dropIfExists('tareas');
    }
};
