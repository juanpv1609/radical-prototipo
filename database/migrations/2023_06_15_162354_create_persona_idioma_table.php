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
        Schema::create('persona_idioma', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('persona_id')->index('FK_persona_idioma_persona');
            $table->integer('idioma_id')->index('FK_persona_idioma_idiomas');
            $table->integer('nivel_oral');
            $table->integer('nivel_escrito');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona_idioma');
    }
};
