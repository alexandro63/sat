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
        Schema::create('gr_ambiente', function (Blueprint $table) {
            $table->id('amb_id');
            $table->string('amb_nombre');
            $table->integer('amb_capacidad')->nullable();
            $table->integer('amb_piso')->nullable();
            $table->string('amb_descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gr_ambiente');
    }
};
