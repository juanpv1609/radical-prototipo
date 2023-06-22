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
        Schema::create('persona_meritos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('persona_id')->index('FK_persona_meritos_persona');
            $table->timestamp('fecha')->useCurrentOnUpdate()->useCurrent();
            $table->integer('autoridad_id')->index('FK_persona_meritos_persona_2');
            $table->integer('is_merito')->default(1);
            $table->longText('descripcion');
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
        Schema::dropIfExists('persona_meritos');
    }
};
