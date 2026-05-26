<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Docente extends Authenticatable
{
    use HasFactory, HasApiTokens;

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

    // Obtenemos la url de la foto de perfil --- DOCENTE

    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(storage_path('app/public/fotos/docentes/' . $this->foto))) {
            return asset('storage/fotos/docentes/' . $this->foto);
        }

        return asset('images/default-avatar.png');
    }

    // Obtenemos la ruta de almacenamiento -- DOCENTE
    public function getFotoPathAttribute()
    {
        return 'fotos/docentes/' . $this->num_control;
    }

        /**
     * obtener los grupos asignados a este docente
     */
    public function gruposAsignados()
    {
        return $this->hasMany(Grupo::class, 'id_docente');
    }

}
