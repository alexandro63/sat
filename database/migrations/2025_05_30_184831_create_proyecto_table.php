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
        Schema::create('proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_docente_revisor')->constrained('docente')->onDelete('cascade');
            $table->foreignId('id_docente_guia')->constrained('docente')->onDelete('cascade');
            $table->foreignId('id_estudiante')->constrained('estudiante')->onDelete('cascade');
            $table->string('titulo');
            $table->string('linea_investigacion');
            $table->string('area_conocimiento');
            $table->decimal('calificacion')->default(0);
            $table->date('fecha_entrega')->nullable();
            $table->date('fecha_defensa')->nullable();
            $table->text('resumen')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto');
    }
};
