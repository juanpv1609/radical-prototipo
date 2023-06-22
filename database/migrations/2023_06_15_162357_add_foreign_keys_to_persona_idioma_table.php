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
        Schema::table('persona_idioma', function (Blueprint $table) {
            $table->foreign(['persona_id'], 'FK_persona_idioma_persona')->references(['id'])->on('persona');
            $table->foreign(['idioma_id'], 'FK_persona_idioma_idiomas')->references(['id'])->on('idiomas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persona_idioma', function (Blueprint $table) {
            $table->dropForeign('FK_persona_idioma_persona');
            $table->dropForeign('FK_persona_idioma_idiomas');
        });
    }
};
