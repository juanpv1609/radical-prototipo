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
        Schema::table('persona_meritos', function (Blueprint $table) {
            $table->foreign(['autoridad_id'], 'FK_persona_meritos_persona_2')->references(['id'])->on('persona');
            $table->foreign(['persona_id'], 'FK_persona_meritos_persona')->references(['id'])->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persona_meritos', function (Blueprint $table) {
            $table->dropForeign('FK_persona_meritos_persona_2');
            $table->dropForeign('FK_persona_meritos_persona');
        });
    }
};
