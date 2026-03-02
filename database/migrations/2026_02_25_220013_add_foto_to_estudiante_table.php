<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migratioNS.php artisan migrate 
     */
    public function up(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            // Agregamos el campo
            $table->string('foto')->nullable()->after('contrasena');
            // Agregamos columna foto, esta puede estar vacia y la colocamos despues de contraseña
        });
    }

    /**
     * Reverse the migrations. php artisan migrat:rollback 
     */
    public function down(): void
    {
        Schema::table('estudiante', function (Blueprint $table) {
            // Quitamos el campo si revertimos la migracion
            $table->dropColumn('foto');
        });
    }
};
