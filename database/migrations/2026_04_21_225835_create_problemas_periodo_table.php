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
        Schema::create('problemas_periodo', function (Blueprint $table) {
            
            $table->id('id_problema');
            $table->integer('id_docente');
            $table->integer('id_periodo');
            $table->integer('id_grupo');
            $table->text('descripcion_problema');
            $table->text('solucion_recomendada');
            $table->integer('numero_estudiantes')->default(0);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problemas_periodo');
    }
};