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
        Schema::create('plantel_administrativo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('per_id')->constrained('persona')->onDelete('cascade');
            $table->string('cargo');
            $table->string('unidad');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_plantel_academico');
    }
};
