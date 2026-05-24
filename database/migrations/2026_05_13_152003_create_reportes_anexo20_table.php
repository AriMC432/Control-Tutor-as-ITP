<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ejecutar la migracion para crear la tabla reportes_anexo20
     */
    public function up(): void
    {
        Schema::create('reportes_anexo20', function (Blueprint $table) {
             $table->id('id_reporte');
            
            // relaciones
            $table->integer('id_coordinador');
            $table->integer('id_carrera');
            $table->integer('id_periodo');
            
            // datos del reporte (json)
            $table->json('datos_docentes');
            $table->json('problemas')->nullable();
            $table->json('observaciones')->nullable();
            
            // estado
            $table->boolean('editado')->default(false);
            $table->timestamp('ultima_edicion')->nullable();
            $table->string('ruta_pdf', 500)->nullable();
            $table->boolean('pdf_generado')->default(false);
            
            $table->timestamps();
            
            // indices
            $table->index('id_coordinador');
            $table->index('id_carrera');
            $table->index('id_periodo');
            
            // unicidad
            $table->unique(['id_coordinador', 'id_carrera', 'id_periodo'], 'unico_reporte20_por_periodo');
        });
    }

    /**
     * revertir la migracion y eliminar la tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_anexo20');
    }
};
