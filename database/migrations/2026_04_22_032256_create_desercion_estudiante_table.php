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
        Schema::create('desercion_estudiante', function (Blueprint $table) {
             $table->id('id_desercion');
            
            // relacion con el estudiante
            $table->integer('id_estudiante');
            
            // relacion con el periodo academico
            $table->integer('id_periodo');
            
            // tipo de desercion: baja definitiva, baja temporal o activo
            $table->enum('tipo_desercion', ['baja_definitiva', 'baja_temporal', 'activo'])->default('activo');
            
            // motivo de la desercion (opcional)
            $table->text('motivo_desercion')->nullable();
            
            // fecha en que se registro la desercion (opcional)
            $table->date('fecha_desercion')->nullable();
            
            // marcas de tiempo de creacion y actualizacion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desercion_estudiante');
    }
};
