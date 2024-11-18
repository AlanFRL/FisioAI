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
        Schema::create('tratamiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostico_id')->constrained('diagnostico')->onDelete('cascade');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
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
        Schema::dropIfExists('tratamiento');
    }
};
