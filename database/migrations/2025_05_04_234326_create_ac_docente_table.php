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
        Schema::create('ac_docente', function (Blueprint $table) {
            $table->id('doc_id');

            $table->foreignId('doc_per_id')->constrained('gr_persona','per_id')->onDelete('cascade');
            $table->string('doc_grado_academico');
            $table->string('doc_observaciones')->nullable();
            $table->date('doc_fec_ing');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_docente');
    }
};
