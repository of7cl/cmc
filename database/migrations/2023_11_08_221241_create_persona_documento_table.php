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
        Schema::create('documento_persona', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('documento_id');
            $table->unsignedBigInteger('rango_id');
            $table->date('fc_inicio')->nullable();
            $table->date('fc_fin')->nullable();

            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('rango_id')->references('id')->on('rangos')->onDelete('cascade');

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
        Schema::dropIfExists('persona_documento');
    }
};
