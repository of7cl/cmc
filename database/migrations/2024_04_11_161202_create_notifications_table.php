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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('icon');
            $table->string('text');
            $table->boolean('readed')->default(false);
            $table->string('alert');            
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('documento_id');
            $table->enum('semaforo', [0,1,2,3,4,5])->default(0); // 0 => defecto, 1=> negro, 2=> rojo, 3=> naranjo, 4=> amarillo, 5=> verde 

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
        Schema::dropIfExists('notifications');
    }
};
