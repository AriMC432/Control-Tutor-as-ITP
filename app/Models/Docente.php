<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Docente extends Authenticatable
{
    use HasFactory;

    // Nombre exacto de la tabla en tu base de datos
    protected $table = 'docente'; 
    protected $primaryKey = 'id_docente';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'paterno', 
        'materno', 
        'num_control', 
        'correo', 
        'contrasena', 
        'id_rol'
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // --- RELACIONES ---

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_docente', 'id_docente');
    }

    public function tutoriasGrupales()
    {
        return $this->hasMany(TutoriaGrupal::class, 'id_docente', 'id_docente');
    }

    public function tutoriasIndividuales()
    {
        return $this->hasMany(TutoriaIndividual::class, 'id_docente');
    }
}