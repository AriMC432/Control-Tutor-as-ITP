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
        Schema::table('grupo', function (Blueprint $table) {
            // agregar columna medio_comunicacion despues de la columna semestre
             $table->string('medio_comunicacion', 255)->nullable()->after('semestre');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo', function (Blueprint $table) {
            // eliminar columna si se revierte
             $table->dropColumn('medio_comunicacion');
        });
    }
};
