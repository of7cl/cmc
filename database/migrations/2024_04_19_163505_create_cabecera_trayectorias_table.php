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
        Schema::create('cabecera_trayectorias', function (Blueprint $table) {
            $table->id();
    
            $table->unsignedBigInteger('trayectoria_id');            
            //$table->unsignedBigInteger('rango_id')->nullable();            
            $table->string('condicion')->nullable();
            $table->date('fc_desde')->nullable();
            $table->date('fc_hasta')->nullable();
            $table->unsignedBigInteger('total_dias')->nullable();
            $table->decimal('factor')->nullable();
            $table->unsignedBigInteger('total_dias_acumulados')->nullable();
            $table->unsignedBigInteger('total_dias_consumidos')->nullable();
            $table->unsignedBigInteger('saldo_dias_pendientes')->nullable();

            $table->foreign('trayectoria_id')->references('id')->on('trayectorias')->onDelete('cascade');            
            //$table->foreign('rango_id')->references('id')->on('rangos')->onDelete('set null');

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
        Schema::dropIfExists('cabecera_trayectorias');
    }
};
