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
        Schema::create('hr_administrativo', function (Blueprint $table) {
            $table->id('adm_id');
            $table->foreignId('adm_per_id')->constrained('gr_persona','per_id')->onDelete('cascade');
            $table->string('adm_grado_academico');
            $table->date('adm_fec_ing');
            $table->string('adm_cargo')->nullable();
            $table->decimal('adm_pago');
            $table->string('adm_obs')->nullable();
            $table->date('adm_fec_ini');
            $table->date('adm_fec_fin');
            $table->boolean('adm_estado')->default(0);
            $table->json('adm_plan_horario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_administrativo');
    }
};
