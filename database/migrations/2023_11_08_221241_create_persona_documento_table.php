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
            $table->string('nm_archivo_original')->nullable();
            $table->string('nm_archivo_guardado')->nullable();
            $table->enum('estado', [0,1])->default(0); // 0 => activo, 1=> pendiente
            $table->enum('semaforo', [0,1,2,3,4,5])->default(0); // 0 => defecto, 1=> negro, 2=> rojo, 3=> naranjo, 4=> amarillo, 5=> verde 

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
