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
        Schema::table('persona_estudio', function (Blueprint $table) {
            $table->foreign(['nivel_id'], 'FK_persona_estudio_nivel_estudio')->references(['id'])->on('nivel_estudio');
            $table->foreign(['persona_id'], 'FK_persona_estudio_persona')->references(['id'])->on('persona');
            $table->foreign(['estado_estudio_id'], 'FK_persona_estudio_estado_estudio')->references(['id'])->on('estado_estudio');
            $table->foreign(['pais_id'], 'FK_persona_estudio_paises')->references(['id'])->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persona_estudio', function (Blueprint $table) {
            $table->dropForeign('FK_persona_estudio_nivel_estudio');
            $table->dropForeign('FK_persona_estudio_persona');
            $table->dropForeign('FK_persona_estudio_estado_estudio');
            $table->dropForeign('FK_persona_estudio_paises');
        });
    }
};
