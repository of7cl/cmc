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
        Schema::create('rango_documento', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rango_id');
            $table->unsignedBigInteger('documento_id');

            $table->foreign('rango_id')->references('id')->on('rangos');
            $table->foreign('documento_id')->references('id')->on('documentos');

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
        Schema::dropIfExists('rango_documento');
    }
};
