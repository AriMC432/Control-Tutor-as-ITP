<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\FirmaReporte;

class FirmaReporteController extends Controller
{
    public function index()
    {
        $userRole = Session::get('user_role');
        if ($userRole != 'Soporte') {
            return redirect('/')->with('error', 'No tienes permiso');
        }
        
        $firmasJefe = FirmaReporte::where('tipo', 'jefe_departamento')
            ->orderBy('orden')
            ->get();
        
        $firmasCoordinador = FirmaReporte::where('tipo', 'coordinador_tutoria')
            ->orderBy('orden')
            ->get();
        
        return view('reportes.firmas', compact('firmasJefe', 'firmasCoordinador'));
    }
    
    public function store(Request $request)
    {
        $userRole = Session::get('user_role');
        if ($userRole != 'Soporte') {
            return response()->json(['success' => false], 403);
        }
        
        $request->validate([
            'tipo' => 'required|in:jefe_departamento,coordinador_tutoria',
            'nombre' => 'required|string|max:200',
            'cargo' => 'required|string|max:200'
        ]);
        
        $ultimoOrden = FirmaReporte::where('tipo', $request->tipo)->max('orden');
        
        FirmaReporte::create([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
            'cargo' => $request->cargo,
            'orden' => ($ultimoOrden ?? 0) + 1
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function destroy($id)
    {
        $userRole = Session::get('user_role');
        if ($userRole != 'Soporte') {
            return response()->json(['success' => false], 403);
        }
        
        $firma = FirmaReporte::findOrFail($id);
        $firma->delete();
        
        return response()->json(['success' => true]);
    }
}