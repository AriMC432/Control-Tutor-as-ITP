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
        Schema::create('reportes_anexo19', function (Blueprint $table) {
            $table->id('id_reporte');
            
            // relaciones (usar 'integer' normal, igual que en tabla docente)
            $table->integer('id_docente');
            $table->integer('id_grupo');
            $table->integer('id_periodo');
            
            // datos del reporte
            $table->json('datos_estudiantes');
            $table->json('problemas')->nullable();
            $table->json('indicadores')->nullable();
            
            // metadatos
            $table->string('medio_comunicacion')->nullable();
            $table->integer('id_encabezado_usado')->nullable();
            
            // estado
            $table->boolean('editado')->default(false);
            $table->timestamp('ultima_edicion')->nullable();
            $table->string('ruta_pdf', 500)->nullable();
            $table->boolean('pdf_generado')->default(false);
            
            $table->timestamps();
            
            // indices para mejorar rendimiento
            $table->index('id_docente');
            $table->index('id_grupo');
            $table->index('id_periodo');
            
            // unicidad
            $table->unique(['id_docente', 'id_grupo', 'id_periodo'], 'unico_reporte_por_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_anexo19');
    }
};
