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
        Schema::create('encabezados_reporte', function (Blueprint $table) {
            $table->id('id_encabezado');

            // relacion con periodo (opcional)
            $table->unsignedInteger('id_periodo')->nullable();

            // tipo de reporte
            $table->string('tipo_reporte', 50)->default('anexo19');

            // datos de la imagen
            $table->string('ruta_imagen', 500);
            $table->string('nombre_original', 255);
            $table->integer('tamano_bytes')->nullable();
            $table->string('mime_type', 50)->default('image/png');

            // estado
            $table->boolean('activo')->default(true);

            // quien la subio
            $table->unsignedInteger('subido_por');
            $table->string('subido_por_rol', 50);

            // metadatos
            $table->integer('ancho')->nullable();
            $table->integer('alto')->nullable();

            $table->timestamps();

            // indices (sin restriccion unica)
            $table->index('id_periodo');
            $table->index('tipo_reporte');
            $table->index('activo');
            $table->index('subido_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encabezados_reporte');
    }
};
