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
        Schema::table('reportes_anexo19', function (Blueprint $table) {
             // fechas del reporte
            $table->date('fecha_llenado')->nullable()->after('id_periodo');
            $table->date('fecha_entrega')->nullable()->after('fecha_llenado');
            
            // firmas seleccionadas (se guarda el texto exacto usado)
            $table->string('firma_coordinador_nombre', 200)->nullable()->after('fecha_entrega');
            $table->string('firma_coordinador_cargo', 200)->nullable()->after('firma_coordinador_nombre');
            $table->string('firma_jefe_nombre', 200)->nullable()->after('firma_coordinador_cargo');
            $table->string('firma_jefe_cargo', 200)->nullable()->after('firma_jefe_nombre');
            
            // ruta del encabezado usado (para preservar la imagen original)
            $table->string('encabezado_ruta', 500)->nullable()->after('id_encabezado_usado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reportes_anexo19', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_llenado',
                'fecha_entrega',
                'firma_coordinador_nombre',
                'firma_coordinador_cargo',
                'firma_jefe_nombre',
                'firma_jefe_cargo',
                'encabezado_ruta'
            ]);
        });
    }
};
