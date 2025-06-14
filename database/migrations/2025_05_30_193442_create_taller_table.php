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
        Schema::create('taller', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->foreignId('id_metodologia')->constrained('metodologia')->onDelete('cascade');
            $table->string('tipo_taller');
            $table->string('evaluacion_final');
            $table->string('duracion');
            $table->string('resultado')->nullable();
            $table->date('fecha_realizacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taller');
    }
};
