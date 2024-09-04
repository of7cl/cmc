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
        Schema::create('ajuste_trayectorias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('trayectoria_id');

            $table->integer('vac_legales_lv')->default(0);
            $table->integer('vac_legales_ld')->default(0);
            $table->integer('embarco_1x1')->default(0);
            $table->integer('ajuste_descanso')->default(0);
            $table->integer('feriado_progresivo')->default(0);

            $table->foreign('trayectoria_id')->references('id')->on('trayectorias')->onDelete('cascade');

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
        Schema::dropIfExists('ajuste_trayectorias');
    }
};
