<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
class PeriodoController extends Controller
{
    public function cambiarPeriodo(Request $request)
    {
        // Buscamos el período seleccionado
        $periodo = Periodo::where('id_periodo', $request->id_periodo)->first();
        
        if ($periodo) {
            // Guardamos el ID y el Nombre en la memoria temporal (sesión) del usuario
            session([
                'periodo_id' => $periodo->id_periodo, 
                'periodo_nombre' => $periodo->nombre
            ]);
        }
        
        // Lo regresamos a la pantalla donde estaba
        return redirect()->back(); 
    }
// 1. FUNCIÓN PARA EL LADO IZQUIERDO: Crear y Activar Nuevo Ciclo
    public function guardarPeriodo(Request $request)
    {
        // Apagamos todos los periodos existentes en la base de datos
        DB::table('periodo')->update(['activo' => 0]);

        // Insertamos el nuevo ciclo y lo nacemos como ACTIVO (1)
        $idNuevo = DB::table('periodo')->insertGetId([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'activo' => 1
        ]);

        // Actualizamos la sesión del Jefe para que vea el cambio arriba
        session([
            'periodo_id' => $idNuevo, 
            'periodo_nombre' => $request->nombre
        ]);

        return redirect()->back()->with('success', 'El nuevo ciclo escolar se creó y activó correctamente.');
    }

    // 2. FUNCIÓN PARA EL LADO DERECHO: Activar un ciclo del historial
    public function activarGlobal(Request $request)
    {
        // 1. Apagamos todos los períodos en la base de datos
        DB::table('periodo')->update(['activo' => 0]);

        // 2. Encendemos únicamente el que seleccionaste
        DB::table('periodo')
            ->where('id_periodo', $request->id_periodo)
            ->update(['activo' => 1]);

        // 3. Actualizamos la sesión para que tu barra azul cambie
        $periodoNuevo = DB::table('periodo')->where('id_periodo', $request->id_periodo)->first();
        if($periodoNuevo){
            session([
                'periodo_id' => $periodoNuevo->id_periodo, 
                'periodo_nombre' => $periodoNuevo->nombre
            ]);
        }

        return redirect()->back()->with('success', 'Se cambió el período activo exitosamente.');
    }
}