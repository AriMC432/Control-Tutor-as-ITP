<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    // Configuración para tu esquema de DB
    protected $table = 'ROLES';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    /**
     * Opcional: Un Rol puede tener muchos Docentes
     */
    public function docentes()
    {
        return $this->hasMany(Docente::class, 'id_rol', 'id_rol');
    }
}