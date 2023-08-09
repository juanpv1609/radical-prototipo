<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingKeyToTareasAdjuntos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tareas_adjuntos', function (Blueprint $table) {
            
            $table->foreign(['tarea_id'], 'FK_tareas_adjuntos_tareas')->references(['id'])->on('tareas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tareas_adjuntos', function (Blueprint $table) {
                
                $table->dropForeign('FK_tareas_adjuntos_tareas');
        });
    }
}
