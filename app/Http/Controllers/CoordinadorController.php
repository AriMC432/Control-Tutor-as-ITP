<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Estudiante;
use App\Models\TutoriaIndividual;
use App\Models\TutoriaGrupal;
use App\Models\DetalleTutoriaGrupal;
use App\Models\Canalizacion;
use App\Models\Docente;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;
use App\Models\Grupo;
class CoordinadorController extends Controller
{
    // app/Http/Controllers/CoordinadorController.php

public function inicio()
{
    // 1. Obtener el periodo activo
    $periodoActivo = DB::table('periodo')->where('activo', 1)->first();

    if (!$periodoActivo) {
        return view('coordinador.index', ['periodoActivo' => null]);
    }

    // 2. Contar Tutores únicos que tienen grupos en este periodo
    $totalTutores = DB::table('grupo')
        ->where('id_periodo', $periodoActivo->id_periodo)
        ->distinct('id_docente')
        ->count('id_docente');

    // 3. Contar Grupos en este periodo
    $totalGrupos = DB::table('grupo')
        ->where('id_periodo', $periodoActivo->id_periodo)
        ->count();

    // 4. Tutorías en el mes actual (Suma de individuales y grupales)
    $inicioMes = now()->startOfMonth();
    $finMes = now()->endOfMonth();

    $grupalesMes = DB::table('tutoria_grupal')
        ->whereBetween('fecha', [$inicioMes, $finMes])
        ->count();

    $individualesMes = DB::table('tutoria_individual')
        ->whereBetween('fecha', [$inicioMes, $finMes])
        ->count();

    $tutoriasMes = $grupalesMes + $individualesMes;

    // 5. Asistencia Promedio (Lógica simple basada en tutorías individuales)
    // Calculamos el promedio de la columna 'asistencia' (1 asistió, 0 no asistió)
    $asistenciaPromedioRaw = DB::table('tutoria_individual')
        ->join('docente', 'tutoria_individual.id_docente', '=', 'docente.id_docente')
        ->join('grupo', 'docente.id_docente', '=', 'grupo.id_docente')
        ->where('grupo.id_periodo', $periodoActivo->id_periodo)
        ->whereNotNull('asistencia')
        ->avg('asistencia');

    $asistenciaPromedio = round($asistenciaPromedioRaw * 100, 1);

    // Enviar todo a la vista
    return view('coordinador.index', compact(
        'periodoActivo', 
        'totalTutores', 
        'totalGrupos', 
        'tutoriasMes', 
        'asistenciaPromedio'
    ));
}

    public function informes()
    {
        $periodoActual = Periodo::where('activo', 1)->first();
        return view('coordinador.informes', compact('periodoActual'));
    }

    public function reportes()
    {
        $periodoActual = Periodo::where('activo', 1)->first();
        return view('coordinador.reportes', compact('periodoActual'));
    }

// app/Http/Controllers/CoordinadorController.php

public function seguimiento(Request $request)
{
    $periodoActual = Periodo::where('activo', 1)->first();

    if (!$periodoActual) {
        return view('coordinador.seguimiento', ['seguimiento' => [], 'periodoActual' => null]);
    }

    // Rango del mes actual para el conteo de tutorías
    $inicioMes = now()->startOfMonth();
    $finMes = now()->endOfMonth();

    // 1. Obtenemos los grupos del periodo con sus docentes y carreras
    $seguimiento = Grupo::where('id_periodo', $periodoActual->id_periodo)
        ->with(['docente', 'carrera'])
        ->get()
        ->map(function ($grupo) use ($inicioMes, $finMes) {
            
            // 2. Contar tutorías grupales e individuales del MES para este grupo/tutor
            $grupales = TutoriaGrupal::where('id_grupo', $grupo->id_grupo)
                ->whereBetween('fecha', [$inicioMes, $finMes])
                ->count();

            $individuales = TutoriaIndividual::where('id_docente', $grupo->id_docente)
                ->whereBetween('fecha', [$inicioMes, $finMes])
                ->count();

            // 3. Obtener la fecha de la última sesión registrada
            $ultimaG = TutoriaGrupal::where('id_grupo', $grupo->id_grupo)->max('fecha');
            $ultimaI = TutoriaIndividual::where('id_docente', $grupo->id_docente)->max('fecha');
            $ultimaSesion = max($ultimaG, $ultimaI);

            // 4. Calcular asistencia promedio (Individuales)
            $asistenciaProm = TutoriaIndividual::where('id_docente', $grupo->id_docente)
                ->whereNotNull('asistencia')
                ->avg('asistencia') ?? 0;

            return (object)[
'tutor' => ($grupo->docente?->nombre ?? 'Sin') . ' ' . ($grupo->docente?->paterno ?? 'Asignar'),                'grupo' => $grupo->nombre,
                'carrera' => $grupo->carrera->nombre ?? 'N/A',
                'tutorias_mes' => $grupales + $individuales,
                'asistencia_prom' => round($asistenciaProm * 100, 0),
                'ultima_sesion' => $ultimaSesion ? \Carbon\Carbon::parse($ultimaSesion)->format('d/m/Y') : 'Sin sesiones',
                'estado' => ($grupales + $individuales > 0) ? 'Activo' : 'Pendiente'
            ];
        });

    return view('coordinador.seguimiento', compact('seguimiento', 'periodoActual'));
}


    public function viewPerfil()
    {
        $idUsuario = Session::get('user_id');
        $periodoActual = Periodo::where('activo', 1)->first();
        // Buscar el objeto Docente (que incluye al Coordinador)
        // Usamos with('rol') para poder mostrar el rol en la vista
        $usuario = Docente::with('rol')->findOrFail($idUsuario);

        return view('coordinador.perfil', compact('usuario', 'periodoActual'));
    }

    /**
     * Procesa la actualización de la contraseña del Coordinador logueado.
     */
    public function updatePassword(Request $request)
    {
        $idUsuario = Session::get('user_id');
        $usuario = Docente::findOrFail($idUsuario);

        // 1. Validación de datos con reglas Pro
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->contrasena)) {
                        $fail('La contraseña actual ingresada no es correcta.');
                    }
                }
            ],

            // Nueva contraseña: Reglas robustas
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()      // Al menos una letra
                    ->mixedCase()    // Mayúsculas y minúsculas
                    ->numbers()      // Al menos un número
                    ->symbols()      // Al menos un símbolo (!@#$%...)
                    ->uncompromised(), // Verifica que no haya sido hackeada antes
            ],

        ], [
            // Mensajes de error personalizados y traducidos
            'current_password.required' => 'Debes ingresar tu contraseña actual para confirmar el cambio.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe contener al menos una letra.',
            'password.mixed' => 'La contraseña debe contener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
            'password.uncompromised' => 'Esta contraseña es poco segura porque ha aparecido en filtraciones de datos. Elige una más original.',
        ]);

        // 2. Actualizar la contraseña
        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // 3. Redireccionar con éxito
        return back()->with('success', '¡Tu contraseña se cambió correctamente!');
    }

    // Formulario para editar foto -- COORDINADOR
    public function editarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        return view('coordinador.editar-foto', compact('usuario'));
    }

    // Actualizar foto -- COORDINADOR
    public function actualizarFoto(Request $request)
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

       $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Debes seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($usuario->foto && file_exists(storage_path('app/public/fotos/docentes/' . $usuario->foto))) {
                unlink(storage_path('app/public/fotos/docentes/' . $usuario->foto));
            }

            // Guardar nueva foto
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreArchivo = $usuario->num_control . '.' . $extension;
            $path = $request->file('foto')->storeAs('fotos/docentes', $nombreArchivo, 'public');

            $usuario->foto = $nombreArchivo;
            $usuario->save();

            return redirect()->route('coordinador.perfil.view')->with('success', 'Foto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo subir la foto.');
    }

    // Eliminar foto -- COORDINADOR
    public function eliminarFoto()
    {
        $userId = Session::get('user_id');
        $usuario = Docente::findOrFail($userId);

        if ($usuario->foto) {
            $rutaArchivo = storage_path('app/public/fotos/docentes/' . $usuario->foto);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $usuario->foto = null;
            $usuario->save();

            return redirect()->route('coordinador.perfil.view')->with('success', 'Foto eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto para eliminar.');
    }
}
