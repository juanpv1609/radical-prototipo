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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tipo_identificacion')->default(1);
            $table->string('dni', 20)->nullable();
            $table->longText('razon_social')->nullable();
            $table->longText('nombre_comercial');
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 25)->nullable();
            $table->longText('direccion')->nullable();
            $table->smallInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('clientes');
    }
};
