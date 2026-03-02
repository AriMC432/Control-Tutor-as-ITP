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
        Schema::table('docente', function (Blueprint $table) {
            //
             $table->string('foto')->nullable()->after('contrasena');
             // Agregamos columna foto, esta puede estar vacia y la colocamos despues de contraseña
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docente', function (Blueprint $table) {
            //
             $table->dropColumn('foto');
        });
    }
};
