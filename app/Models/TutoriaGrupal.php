<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutoriaGrupal extends Model
{
    protected $table = 'tutoria_grupal';
    protected $primaryKey = 'id_tutoria_grupal';
    public $timestamps = false;

    // --- CORRECCIÓN AQUÍ ---
    // Se agregó 'hora' para permitir que se guarde este dato
    protected $fillable = ['tema', 'fecha', 'hora', 'id_docente', 'id_grupo'];

    protected $casts = [
        'fecha' => 'date',
    ];

    // --- RELACIONES ---

    /**
     * Relación: La tutoría fue impartida por un Docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    /**
     * Relación: La tutoría se impartió a un Grupo específico.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }
    
    /**
     * Relación: Detalles de asistencia de los alumnos (Tabla pivote/detalle).
     */
    public function detalles()
    {
        return $this->hasMany(DetalleTutoriaGrupal::class, 'id_tutoria', 'id_tutoria_grupal');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'detalle_tutoria_grupal', 'id_tutoria', 'id_estudiante')
                    ->withPivot('asistencia', 'observaciones');
    }
}