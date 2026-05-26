<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FirmaReporte;

class FirmasReporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // firmas para jefe de departamento
        FirmaReporte::create([
            'tipo' => 'jefe_departamento',
            'nombre' => 'Dr. Arturo González Cerón',
            'cargo' => 'Jefe de Departamento Académico',
            'activo' => true,
            'orden' => 1
        ]);

        // firmas para coordinador de tutoria
        FirmaReporte::create([
            'tipo' => 'coordinador_tutoria',
            'nombre' => 'M.C. Anselmo Hernández Ramírez',
            'cargo' => 'Coordinador de Tutoría del Departamento Académico',
            'activo' => true,
            'orden' => 1
        ]);
    }
}
