<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    // Nombre de la tabla según tu SQL
    protected $table = 'carreras'; 
    protected $primaryKey = 'id_carrera';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    // Relación inversa: Una carrera tiene muchos grupos
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_carrera', 'id_carrera');
    }
}