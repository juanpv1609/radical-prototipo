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
        Schema::create('persona_estudio', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('persona_id')->index('FK_persona_estudio_persona');
            $table->unsignedBigInteger('pais_id')->nullable()->index('FK_persona_estudio_paises');
            $table->longText('titulo')->nullable();
            $table->longText('descripcion');
            $table->integer('nivel_id')->default(0)->index('FK_persona_estudio_nivel_estudio');
            $table->integer('estado_estudio_id')->default(0)->index('FK_persona_estudio_estado_estudio');
            $table->integer('certificado')->nullable();
            $table->longText('institucion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('duracion_horas')->nullable();
            $table->binary('documentos')->nullable();
            $table->integer('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona_estudio');
    }
};
