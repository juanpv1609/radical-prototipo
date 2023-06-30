<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_identificacion')->default(1);
            $table->string('dni',20);
            $table->string('razon_social',100);

            $table->string('nombre_comercial',100);
            $table->string('correo',30);
            $table->string('telefono',15);
            $table->string('direccion',200);
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
            //$table->index('tipo_identificacion');

            //$table->foreign('tipo_identificacion')->references('id')->on('tipo_identificacion');

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
}
