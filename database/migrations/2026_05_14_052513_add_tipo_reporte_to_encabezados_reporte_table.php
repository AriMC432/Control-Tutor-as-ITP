<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('encabezados_reporte', function (Blueprint $table) {
            // agregar columna tipo_reporte
            if (!Schema::hasColumn('encabezados_reporte', 'tipo_reporte')) {
                $table->string('tipo_reporte', 50)->default('anexo19')->after('id_periodo');
            }
        });

        // eliminar restriccion unica existente
        DB::statement('ALTER TABLE encabezados_reporte DROP INDEX unico_activo_por_periodo');

        // crear nueva restriccion unica que incluya tipo_reporte
        Schema::table('encabezados_reporte', function (Blueprint $table) {
            $table->unique(['id_periodo', 'tipo_reporte', 'activo'], 'unico_activo_por_periodo_y_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encabezados_reporte', function (Blueprint $table) {

            $table->dropUnique('unico_activo_por_periodo_y_tipo');
            $table->dropColumn('tipo_reporte');
        });
    }
};
