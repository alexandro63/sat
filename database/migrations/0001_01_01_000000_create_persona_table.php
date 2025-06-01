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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidopat')->nullable();
            $table->string('apellidomat')->nullable();
            $table->string('carnet', 15)->unique();
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('correo', 100)->nullable()->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('estado')->default(1);
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
