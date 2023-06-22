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
        Schema::create('perfil_puesto', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('area_id')->index('FK_perfil_puesto_areas');
            $table->string('descripcion', 200)->default('');
            $table->longText('funciones')->nullable();
            $table->longText('responsabilidades')->nullable();
            $table->smallInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_puesto');
    }
};
