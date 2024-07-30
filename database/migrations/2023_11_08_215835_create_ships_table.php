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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();

            $table->string('codigo')->nullable();
            $table->string('nombre');
            $table->string('imo');
            $table->string('dwt');
            $table->string('trg');
            $table->string('loa');
            $table->string('manga');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('ship_tipo_id')->nullable();                        

            $table->enum('estado', [1,2])->default(1); // 1 => activo, 2=> inactivo            

            $table->foreign('ship_tipo_id')->references('id')->on('ship_tipos')->onDelete('set null');;            

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
        Schema::dropIfExists('ships');
    }
};
