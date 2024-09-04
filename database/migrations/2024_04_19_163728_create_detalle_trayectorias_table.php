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
        Schema::create('detalle_trayectorias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('trayectoria_id');
            $table->unsignedBigInteger('ship_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->date('fc_desde')->nullable();
            $table->date('fc_hasta')->nullable();
            $table->integer('total_dias_calendario')->nullable();
            $table->integer('descanso_convenio')->nullable();
            $table->integer('saldo_descanso')->nullable();
            $table->integer('dias_vacaciones_consumidas')->nullable();
            $table->integer('dias_inhabiles_generados')->nullable();
            $table->integer('dias_inhabiles_favor')->nullable();
            $table->integer('dias_inhabiles_consumidos')->nullable();
            $table->string('ajuste')->nullable();
            $table->string('observaciones')->nullable();

            $table->foreign('trayectoria_id')->references('id')->on('trayectorias')->onDelete('cascade');
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('set null');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('set null');
            $table->foreign('plaza_id')->references('id')->on('rangos')->onDelete('set null');

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
        Schema::dropIfExists('detalle_trayectorias');
    }
};
