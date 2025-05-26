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

        Schema::create('ad_grupo_usuario', function (Blueprint $table) {
            $table->id('gus_id');

            $table->foreignId('gus_usu_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('gus_gru_id')->constrained('ad_grupo', 'gru_id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_grupo_usuario');
    }
};
