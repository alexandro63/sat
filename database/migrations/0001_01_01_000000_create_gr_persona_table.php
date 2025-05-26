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
        Schema::create('gr_persona', function (Blueprint $table) {
            $table->id('per_id');
            $table->string('per_nombres');
            $table->string('per_apellidopat')->nullable();
            $table->string('per_apellidomat')->nullable();
            $table->string('per_ci', 15);
            $table->string('per_direccion', 100)->nullable();
            $table->string('per_telefono', 15)->nullable();
            $table->string('per_celular', 15)->nullable();
            $table->string('per_email', 100)->nullable();
            $table->date('per_fechanac')->nullable();
            $table->boolean('per_estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gr_persona');
    }
};
