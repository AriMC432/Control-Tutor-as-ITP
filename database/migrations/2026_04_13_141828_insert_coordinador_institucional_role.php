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
        // Insertar el nuevo rol "Coordinador Institucional" con id_rol = 5
        DB::table('roles')->insert([
            'id_rol' => 5,
            'nombre' => 'Coordinador Institucional',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar el rol "Coordinador Institucional"
        DB::table('roles')->where('nombre', 'Coordinador Institucional')->delete();
    }
};
