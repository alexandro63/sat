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
        Schema::create('ac_alumno', function (Blueprint $table) {
            $table->id('alu_id');
            $table->foreignId('alu_per_id')->constrained('gr_persona', 'per_id')->onDelete('cascade');
            $table->foreignId('alu_car_id')->constrained('ac_carrera', 'car_id')->onDelete('cascade');
            $table->decimal('alu_reg_matr');
            $table->decimal('alu_mensualidad');
            $table->date('alu_fec_ing');
            $table->date('alu_fec_pago');
            $table->string('alu_turno');
            $table->string('alu_curso');
            $table->string('alu_obs')->nullable();
            $table->boolean('alu_estado')->default(0);
            $table->boolean('alu_con_car')->default(0);
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
