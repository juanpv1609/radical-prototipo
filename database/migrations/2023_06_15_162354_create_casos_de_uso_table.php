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
        Schema::create('casos_de_uso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->longText('nombre');
            $table->longText('descripcion');
            $table->string('tipo', 10)->comment('IT OT');
            $table->longText('fuentes')->nullable();
            $table->smallInteger('estado')->default(1);
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
        Schema::dropIfExists('casos_de_uso');
    }
};
