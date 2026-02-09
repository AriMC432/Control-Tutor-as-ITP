<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleTutoriaGrupal extends Model
{
    // Nombre exacto de la tabla en tu base de datos
    protected $table = 'detalle_tutoria_grupal';

    public $timestamps = false;
    
    // Indicamos que no usa un ID auto-incremental estándar
    public $incrementing = false; 

    protected $fillable = [
        'id_estudiante', 
        'id_tutoria', 
        'asistencia', 
        'observaciones'
    ];
    
    // Relación a la tutoría grupal
    public function tutoriaGrupal()
    {
        return $this->belongsTo(TutoriaGrupal::class, 'id_tutoria', 'id_tutoria_grupal');
    }

    // Relación al estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }

}
