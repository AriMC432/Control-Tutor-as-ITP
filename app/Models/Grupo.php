<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProblemaPeriodo;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'GRUPO';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;

    // Permitir asignación masiva para estos campos
    protected $fillable = [
        'nombre', 
        'semestre', 
        'id_carrera', 
        'id_generacion', 
        'id_docente', 
        'id_periodo'
    ];

    /**
     * Relación: Un Grupo tiene una Carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }

    /**
     * Relación: Un Grupo pertenece a una Generación.
     */
    public function generacion()
    {
        return $this->belongsTo(Generacion::class, 'id_generacion', 'id_generacion');
    }

    /**
     * Relación: Un Grupo tiene un Docente (Tutor) asignado.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    /**
     * ALIAS: Mantenemos 'tutor' por compatibilidad con tus vistas antiguas.
     * Si usas $grupo->tutor->nombre, esto evitará el error.
     */
    public function tutor()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    /**
     * Relación: Un Grupo pertenece a un Periodo.
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo', 'id_periodo');
    }

    /**
     * Relación Inversa: Un Grupo tiene muchos Estudiantes.
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_grupo', 'id_grupo');
    }

    // CAMPO PARA LA DESERCION DE ESTUDIANTE ---- ANEXO 19 FUNCION -----------------------------------------------

     // obtener el medio de comunicacion del grupo si no tiene valor, usar un texto por defecto
    public function getMedioComunicacionAttribute($value)
    {
        return $value ?? 'personal, whatsapp y sesiones virtuales';
    }

   // relacion con problemas registrados 
    public function problemasPeriodo()
    {
        return $this->hasMany(ProblemaPeriodo::class, 'id_grupo');
    }
}