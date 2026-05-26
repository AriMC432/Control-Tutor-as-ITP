<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\EncabezadoReporte;
use App\Models\Periodo;
use Intervention\Image\ImageManager;

class EncabezadoReporteController extends Controller
{
    /**
     * mostrar formulario para subir encabezado
     */
       public function index()
    {
        $periodoActivo = Periodo::where('activo', 1)->first();
        $tiposReporte = ['anexo19', 'anexo20'];
        
        $encabezadosPorTipo = [];
        foreach ($tiposReporte as $tipo) {
            $encabezadosPorTipo[$tipo] = EncabezadoReporte::where('tipo_reporte', $tipo)
                ->where('activo', true)
                ->first();
        }
        
        $historial = EncabezadoReporte::with('periodo')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        
        return view('encabezados.index', compact('periodoActivo', 'encabezadosPorTipo', 'historial', 'tiposReporte'));
    }
    
    /**
     * subir nueva imagen de encabezado
     */
    public function subir(Request $request)
    {
        // obtener rol del usuario logueado
        $userRole = Session::get('user_role');
        
        // roles autorizados
        $rolesAutorizados = ['Jefe', 'Soporte'];
        
        if (!in_array($userRole, $rolesAutorizados)) {
            return back()->with('error', 'No tienes permiso para subir el encabezado');
        }
        
        // validar archivo
        $request->validate([
            'encabezado' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_periodo' => 'nullable|exists:periodo,id_periodo',
            'tipo_reporte' => 'required|string|in:anexo19,anexo20'
        ]);
        
        $idPeriodo = $request->id_periodo;
        $tipoReporte = $request->tipo_reporte;
        $periodoActivo = Periodo::where('activo', 1)->first();
        
        // si no se especifica periodo, usar el activo
        if (!$idPeriodo && $periodoActivo) {
            $idPeriodo = $periodoActivo->id_periodo;
        }
        
        // desactivar TODOS los encabezados de este periodo y tipo
        EncabezadoReporte::where('id_periodo', $idPeriodo)
            ->where('tipo_reporte', $tipoReporte)
            ->update(['activo' => false]);
        
        // procesar y guardar imagen
        $archivo = $request->file('encabezado');
        $nombreOriginal = $archivo->getClientOriginalName();
        $extension = $archivo->getClientOriginalExtension();
        $timestamp = now()->format('Ymd_His');
        $nombreArchivo = "encabezado_{$tipoReporte}_{$timestamp}.{$extension}";
        
        // guardar en storage
        $ruta = $archivo->storeAs('encabezados_reporte', $nombreArchivo, 'public');
        
        // obtener dimensiones
        $imageInfo = getimagesize($archivo->getPathname());
        $ancho = $imageInfo[0] ?? null;
        $alto = $imageInfo[1] ?? null;
        
        // crear nuevo registro activo
        EncabezadoReporte::create([
            'id_periodo' => $idPeriodo,
            'tipo_reporte' => $tipoReporte,
            'ruta_imagen' => $ruta,
            'nombre_original' => $nombreOriginal,
            'tamano_bytes' => $archivo->getSize(),
            'mime_type' => $archivo->getMimeType(),
            'activo' => true,
            'subido_por' => Session::get('user_id'),
            'subido_por_rol' => $userRole,
            'ancho' => $ancho,
            'alto' => $alto
        ]);
        
        return back()->with('success', 'Encabezado para ' . strtoupper($tipoReporte) . ' subido correctamente');
    }

    /**
     * eliminar un encabezado (solo si no esta activo)
     */
    public function eliminar($id)
    {
        $userRole = Session::get('user_role');
        $rolesAutorizados = ['Jefe', 'Soporte'];
        
        if (!in_array($userRole, $rolesAutorizados)) {
            return back()->with('error', 'No tienes permiso para eliminar encabezados');
        }
        
        $encabezado = EncabezadoReporte::findOrFail($id);
        
        if ($encabezado->activo) {
            return back()->with('error', 'No se puede eliminar el encabezado activo. Desactivalo primero.');
        }
        
        // eliminar archivo fisico
        if (Storage::disk('public')->exists($encabezado->ruta_imagen)) {
            Storage::disk('public')->delete($encabezado->ruta_imagen);
        }
        
        $encabezado->delete();
        
        return back()->with('success', 'Encabezado eliminado correctamente');
    }
    
    /**
     * activar un encabezado historico
     */
       public function activar($id)
    {
        $userRole = Session::get('user_role');
        $rolesAutorizados = ['Jefe', 'Soporte'];
        
        if (!in_array($userRole, $rolesAutorizados)) {
            return back()->with('error', 'No tienes permiso para activar encabezados');
        }
        
        $encabezado = EncabezadoReporte::findOrFail($id);
        
        // desactivar otros encabezados del mismo periodo y tipo
        EncabezadoReporte::where('id_periodo', $encabezado->id_periodo)
            ->where('tipo_reporte', $encabezado->tipo_reporte)
            ->update(['activo' => false]);
        
        // activar el seleccionado
        $encabezado->activo = true;
        $encabezado->save();
        
        return back()->with('success', 'Encabezado activado correctamente');
    }

        /**
     * desactivar un encabezado (no lo elimina, solo lo inactiva)
     */
    public function desactivar($id)
    {
        $userRole = Session::get('user_role');
        $rolesAutorizados = ['Jefe', 'Soporte'];
        
        if (!in_array($userRole, $rolesAutorizados)) {
            return back()->with('error', 'No tienes permiso para desactivar encabezados');
        }
        
        $encabezado = EncabezadoReporte::findOrFail($id);
        $encabezado->activo = false;
        $encabezado->save();
        
        return back()->with('success', 'Encabezado desactivado correctamente');
    }
}