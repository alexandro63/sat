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
        Schema::create('estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('per_id')->constrained('persona')->onDelete('cascade');
            $table->foreignId('programa_academico')->constrained('programa_academico')->onDelete('cascade');
            $table->string('numero_matricula');
            $table->date('fecha_inscripcion');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_alumno');
    }
};
