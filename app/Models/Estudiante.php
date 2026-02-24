<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Estudiante extends Authenticatable
{
    use HasFactory, HasApiTokens;

    // 1. CORRECCIÓN: Minúsculas para compatibilidad universal
    protected $table = 'estudiante';
    
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'paterno', 
        'materno', 
        'num_control', 
        'correo', 
        'contrasena', // Importante para que se pueda llenar al registrar
        'id_grupo'
    ];

    protected $hidden = [
        'contrasena',
    ];

    /**
     * VITAL: Mapeo de contraseña para el Login
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // --- RELACIONES ---

    /**
     * Relación: Un Estudiante pertenece a un Grupo.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Relación: Un Estudiante tiene muchas Tutorías Individuales.
     * (Útil para sacar estadísticas en el Dashboard)
     */
    public function tutoriasIndividuales()
    {
        return $this->hasMany(TutoriaIndividual::class, 'id_estudiante', 'id_estudiante');
    }
}