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
        Schema::create('contrato_destinatario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('contrato_id')->default(0)->index('FK_contratos_destinatarios_contratos');
            $table->integer('destinatario_id')->default(0)->index('FK_contratos_destinatarios_destinatarios');
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('contrato_destinatario');
    }
};
