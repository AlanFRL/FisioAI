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
        Schema::create('set_ejercicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained('set')->onDelete('cascade');
            $table->foreignId('ejercicio_id')->constrained('ejercicio')->onDelete('cascade');
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
        Schema::dropIfExists('set_ejercicio');
    }
};
