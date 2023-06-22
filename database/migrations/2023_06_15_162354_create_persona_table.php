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
        Schema::create('persona', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('perfil_puesto_id');
            $table->string('ci', 15)->nullable();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('pais_id')->default(0)->index('FK_persona_paises');
            $table->integer('nacionalidad_id')->default(0);
            $table->string('telefono', 10)->nullable()->default('0');
            $table->date('fecha_nacimiento')->nullable();
            $table->binary('foto')->nullable();
            $table->longText('funcion_especifica')->nullable();
            $table->longText('responsabilidad_especifica')->nullable();
            $table->longText('autoridad_especifica')->nullable()->comment('poder de desicion');
            $table->binary('documentos')->nullable()->comment('CV,contratos,etc');
            $table->longText('skills')->nullable();
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('persona');
    }
};
