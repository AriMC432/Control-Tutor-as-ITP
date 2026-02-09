<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutoriaIndividual extends Model
{
    protected $table = 'tutoria_individual';
    protected $primaryKey = 'id_tutoria_individual';
    public $timestamps = false;

    // --- CORRECCIÓN AQUÍ ---
    // Se agregó 'hora' para permitir guardar la hora de la sesión
    protected $fillable = ['fecha', 'hora', 'motivo', 'asistencia', 'observaciones', 'id_estudiante', 'id_docente'];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Relación para ver el nombre del alumno
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    /**
     * Relación una tutoría individual pertenece a un Docente (Tutor).
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }
 
    public function canalizaciones()
    {
        return $this->hasMany(Canalizacion::class, 'id_tutoria');
    }
}