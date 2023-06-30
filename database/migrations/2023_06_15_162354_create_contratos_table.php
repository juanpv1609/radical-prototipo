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
        Schema::create('contratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion', 200)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->unsignedBigInteger('cliente_id')->default(0)->index('FK_contratos_clientes');
            $table->unsignedBigInteger('pais_id')->default(0)->index('FK_contratos_paises');
            $table->unsignedBigInteger('area_id')->default(0)->index('FK_contratos_areas');
            $table->string('solucion', 200)->nullable();
            $table->string('marca', 200)->nullable();
            $table->longText('correos')->nullable();
            $table->longText('observacion')->nullable();
            $table->integer('estado');
            $table->longText('adjunto')->nullable();
            $table->smallInteger('alerta_fin_contrato180')->default(0);
            $table->smallInteger('alerta_fin_contrato60')->default(0);
            $table->smallInteger('alerta_fin_contrato30')->default(0);
            $table->smallInteger('alerta_fin_contrato15')->default(0);
            $table->smallInteger('alerta_fin_contrato7')->default(0);
            $table->smallInteger('alerta_fin_contrato')->default(0);
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
        Schema::dropIfExists('contratos');
    }
};
