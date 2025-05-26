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
        Schema::disableForeignKeyConstraints();

        Schema::create('ad_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->text('log_accion');
            $table->string('log_usuario');
            $table->string('log_equipo');
            $table->string('log_ip_equipo');
            $table->date('log_fecha');
            $table->time('log_hora');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_logs');
    }
};
