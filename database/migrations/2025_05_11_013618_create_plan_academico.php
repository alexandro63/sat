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
        Schema::create('plan_academico', function (Blueprint $table) {
            $table->id('plan_id');

            $table->foreignId('plan_mat_id')->constrained('ac_materia', 'mat_id')->onDelete('cascade');
            $table->foreignId('plan_doc_id')->constrained('ac_docente', 'doc_id')->onDelete('cascade');
            $table->foreignId('plan_amb_id')->constrained('gr_ambiente', 'amb_id')->onDelete('cascade');

            $table->date('plan_fec_ini');
            $table->date('plan_fec_fin');
            $table->time('plan_hor_ini');
            $table->json('plan_horario')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_academico');
    }
};
