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
        Schema::create('documento_rango', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rango_id');
            $table->unsignedBigInteger('documento_id');
            
            $table->enum('obligatorio', [1,2])->default(1); // 1 => obligatorio, 2=> no obligatorio

            $table->foreign('rango_id')->references('id')->on('rangos')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

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
        Schema::dropIfExists('documento_rango');
    }
};
