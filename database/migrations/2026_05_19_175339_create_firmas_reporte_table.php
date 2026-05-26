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
        Schema::create('firmas_reporte', function (Blueprint $table) {
            $table->id('id_firma');
            $table->string('tipo', 50); // jefe_departamento, coordinador_tutoria
            $table->string('nombre', 200);
            $table->string('cargo', 200);
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firmas_reporte');
    }
};
