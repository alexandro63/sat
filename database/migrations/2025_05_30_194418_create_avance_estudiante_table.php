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
        Schema::create('avance_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_estudiante')->constrained('estudiante')->onDelete('cascade');
            $table->foreignId('id_modulo')->constrained('modulo')->onDelete('cascade');
            $table->string('responsable');
            $table->string('fecha')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avance_estudiante');
    }
};
