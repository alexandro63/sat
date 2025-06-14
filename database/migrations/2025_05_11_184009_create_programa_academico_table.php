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
        Schema::create('programa_academico', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre_programa');
            $table->string('modalidad');
            $table->string('facultad');
            $table->string('nivel');
            $table->boolean('estado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_academico');
    }
};
