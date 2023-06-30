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
        Schema::create('servicios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre', 100)->default('0');
            $table->longText('descripcion')->nullable();
            $table->unsignedBigInteger('area_id')->default(0)->index('FK__areas');
            $table->integer('estado')->default(1);
            $table->longText('observaciones')->nullable();
            $table->integer('is_recurso')->default(0);
            $table->integer('marca_id');
            $table->integer('modalidad_id');
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
};
