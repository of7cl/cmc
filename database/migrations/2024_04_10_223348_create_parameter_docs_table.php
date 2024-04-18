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
        Schema::create('parameter_docs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('flag_red');
            $table->unsignedBigInteger('flag_yellow');
            $table->unsignedBigInteger('flag_green');

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
        Schema::dropIfExists('parameter_docs');
    }
};
