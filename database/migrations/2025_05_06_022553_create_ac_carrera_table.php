<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ac_carrera', function (Blueprint $table) {
            $table->id('car_id');
            $table->string('car_nombre');
            $table->string('car_descripcion')->nullable();
            $table->integer('car_duracion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_carrera');
    }
};
