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

        Schema::create('ad_grupo', function (Blueprint $table) {
            $table->id('gru_id');
            $table->string('gru_nombre');
            $table->text('gru_obs')->nullable();
            $table->boolean('gru_estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_grupo');
    }
};
