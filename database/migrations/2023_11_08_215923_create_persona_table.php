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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('rut');
            $table->date('fc_nacimiento')->nullable();
            $table->date('fc_ingreso')->nullable();
            $table->date('fc_baja')->nullable();
            $table->string('foto')->nullable();

            $table->enum('estado', [1,2])->default(1); // 1 => activo, 2=> inactivo
            $table->enum('eventual', [1,2])->default(1); // 1 => normal, 2=> eventual
            
            $table->unsignedBigInteger('ship_id')->nullable();            
            $table->unsignedBigInteger('rango_id')->nullable();
            $table->unsignedBigInteger('contrato_tipo_id')->nullable();

            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('set null');;
            $table->foreign('rango_id')->references('id')->on('rangos')->onDelete('set null');;
            $table->foreign('contrato_tipo_id')->references('id')->on('rangos')->onDelete('set null');;

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
        Schema::dropIfExists('personas');
    }
};
