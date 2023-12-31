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

            $table->enum('estado', [1,2])->default(1); // 1 => activo, 2=> inactivo
            
            $table->unsignedBigInteger('ship_id')->nullable();            
            $table->unsignedBigInteger('rango_id')->nullable();

            $table->foreign('ship_id')->references('id')->on('ships');
            $table->foreign('rango_id')->references('id')->on('rangos');

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
