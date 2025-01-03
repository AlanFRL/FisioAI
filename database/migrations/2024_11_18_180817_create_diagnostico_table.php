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
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->float('peso', 5, 2);
            $table->integer('altura')->unsigned();
            $table->string('zona_afectada');
            $table->integer('nivel_dolor')->unsigned();
            $table->integer('lesion_dias')->unsigned();
            $table->boolean('lesion_previa')->default(false);
            $table->string('diagnostico');
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
        Schema::dropIfExists('diagnostico');
    }
};
