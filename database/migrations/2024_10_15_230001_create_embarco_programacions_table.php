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
        Schema::create('embarco_programacions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_programacion')->nullable();
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->unsignedBigInteger('ship_id')->nullable();            
            $table->unsignedBigInteger('rango_id')->nullable();
            $table->unsignedBigInteger('nr_semana')->nullable();
            $table->unsignedBigInteger('nr_mes')->nullable();
            $table->unsignedBigInteger('nr_anio')->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->string('str_color')->nullable();
            $table->string('id_celda')->nullable();

            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('set null');
            $table->foreign('rango_id')->references('id')->on('rangos')->onDelete('set null');            

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
        Schema::dropIfExists('embarco_programacions');
    }
};
