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
        Schema::create('fn_pago', function (Blueprint $table) {
            $table->id('pag_id');
            $table->foreignId('pag_alu_id')->constrained('ac_alumno', 'alu_id')->onDelete('cascade');
            $table->dateTime('pag_fec_hor');
            $table->decimal('pag_monto');
            $table->integer('pag_cuota');
            $table->string('pag_rof')->nullable();
            $table->string('pag_obs')->nullable();
            $table->foreignId('pag_usu_id')->constrained('users');
            $table->enum('pag_tipo', ['efectivo', 'qr', 'transferencia_bancaria'])->default('efectivo')->comment('Tipo de pago: efectivo, QR o transferencia bancaria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fn_pago');
    }
};
