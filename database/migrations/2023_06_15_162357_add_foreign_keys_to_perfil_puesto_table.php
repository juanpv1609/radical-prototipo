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
        Schema::table('perfil_puesto', function (Blueprint $table) {
            $table->foreign(['area_id'], 'FK_perfil_puesto_areas')->references(['id'])->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perfil_puesto', function (Blueprint $table) {
            $table->dropForeign('FK_perfil_puesto_areas');
        });
    }
};
