<?php

namespace App\Http\Controllers\Jefe;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AsesorController extends Controller
{
    /**
     * Mostrar la gestión de asesores.
     */
    public function index()
    {
        $asesores = Asesor::orderBy('nombre')->get();

        return view('jefe.asesorias', compact('asesores'));
    }

    /**
     * Obtener un asesor.
     */
    public function show(Asesor $asesor)
    {
        return response()->json($asesor);
    }

    /**
     * Registrar un asesor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'correo_institucional' => [
                'required',
                'email',
                'max:255',
                'unique:asesores,correo_institucional',
            ],

            'area' => [
                'required',
                'string',
                'max:255',
            ],

            'horarios' => [
                'required',
                'array',
                'min:1',
            ],

            'horarios.*.dia' => [
                'required',
                Rule::in([
                    'Lunes',
                    'Martes',
                    'Miércoles',
                    'Jueves',
                    'Viernes',
                    'Sábado',
                    'Domingo',
                ]),
            ],

            'horarios.*.inicio' => [
                'required',
                'date_format:H:i',
            ],

            'horarios.*.fin' => [
                'required',
                'date_format:H:i',
            ],

            'modalidad' => [
                'required',
                Rule::in([
                    'Presencial',
                    'En línea',
                    'Ambas',
                ]),
            ],

            // NUEVO: Tipo de lugar
            'lugar_tipo' => [
                'required',
                Rule::in([
                    'Aula',
                    'Cubículo',
                    'Laboratorio',
                    'Otro',
                ]),
            ],

            // NUEVO: Detalle del lugar
            'lugar_detalle' => [
                'required',
                'string',
                'max:255',
            ],

        ]);

        $this->validarHorarios($validated['horarios']);

        $validated['correo_institucional'] = strtolower(
            trim($validated['correo_institucional'])
        );

        $validated['lugar_detalle'] = trim(
            $validated['lugar_detalle']
        );

        $validated['estado'] = 'Disponible';

        $asesor = Asesor::create($validated);

        return response()->json([
            'message' => 'Asesor registrado correctamente.',
            'asesor' => $asesor,
        ], 201);
    }

    /**
     * Actualizar un asesor.
     */
    public function update(Request $request, Asesor $asesor)
    {
        $validated = $request->validate([

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'correo_institucional' => [
                'required',
                'email',
                'max:255',
                Rule::unique('asesores', 'correo_institucional')
                    ->ignore($asesor->id),
            ],

            'area' => [
                'required',
                'string',
                'max:255',
            ],

            'horarios' => [
                'required',
                'array',
                'min:1',
            ],

            'horarios.*.dia' => [
                'required',
                Rule::in([
                    'Lunes',
                    'Martes',
                    'Miércoles',
                    'Jueves',
                    'Viernes',
                    'Sábado',
                    'Domingo',
                ]),
            ],

            'horarios.*.inicio' => [
                'required',
                'date_format:H:i',
            ],

            'horarios.*.fin' => [
                'required',
                'date_format:H:i',
            ],

            'modalidad' => [
                'required',
                Rule::in([
                    'Presencial',
                    'En línea',
                    'Ambas',
                ]),
            ],

            // NUEVO: Tipo de lugar
            'lugar_tipo' => [
                'required',
                Rule::in([
                    'Aula',
                    'Cubículo',
                    'Laboratorio',
                    'Otro',
                ]),
            ],

            // NUEVO: Detalle del lugar
            'lugar_detalle' => [
                'required',
                'string',
                'max:255',
            ],

        ]);

        $this->validarHorarios($validated['horarios']);

        $validated['correo_institucional'] = strtolower(
            trim($validated['correo_institucional'])
        );

        $validated['lugar_detalle'] = trim(
            $validated['lugar_detalle']
        );

        $asesor->update($validated);

        return response()->json([
            'message' => 'Asesor actualizado correctamente.',
            'asesor' => $asesor->fresh(),
        ]);
    }

    /**
     * Desactivar asesor.
     */
    public function desactivar(Asesor $asesor)
    {
        $asesor->estado = 'No disponible';

        $asesor->save();

        return response()->json([
            'message' => 'Asesor marcado como no disponible.',
            'asesor' => $asesor,
        ]);
    }

    /**
     * Validar horarios.
     */
    private function validarHorarios(array $horarios): void
    {
        $diasRegistrados = [];

        foreach ($horarios as $horario) {

            $dia = $horario['dia'];

            if (in_array($dia, $diasRegistrados, true)) {

                throw ValidationException::withMessages([
                    'horarios' => [
                        "El día {$dia} está registrado más de una vez.",
                    ],
                ]);
            }

            $diasRegistrados[] = $dia;

            if ($horario['inicio'] >= $horario['fin']) {

                throw ValidationException::withMessages([
                    'horarios' => [
                        "La hora de inicio debe ser anterior a la hora de fin para {$dia}.",
                    ],
                ]);
            }
        }
    }

    /**
     * Eliminar un asesor.
     */
    public function destroy(Asesor $asesor)
    {
        $asesor->delete();

        return response()->json([
            'message' => 'Asesor eliminado correctamente.',
        ]);
    }

    /**
     * Mostrar catálogo de asesores disponibles para alumnos.
     */
    public function catalogo()
    {
        $asesores = Asesor::where('estado', 'Disponible')
            ->orderBy('nombre')
            ->get();

        return view('alumno.asesorias', compact('asesores'));
    }
}
