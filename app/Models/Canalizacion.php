<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canalizacion extends Model
{
    protected $table = 'canalizaciones';
    protected $primaryKey = 'id_canalizacion';
    public $timestamps = false;

    protected $fillable = ['fecha', 'estatus', 'observaciones', 'id_tutoria', 'id_area'];

    protected $casts = [
        'fecha' => 'date',
    ];

    // --- RELACIONES NECESARIAS PARA LA TABLA ---

    /**
     * Relación con la tutoría de origen (para saber quién es el alumno y el docente)
     */
    public function tutoria()
    {
        return $this->belongsTo(TutoriaIndividual::class, 'id_tutoria', 'id_tutoria_individual');
    }

    /**
     * Relación con el área de destino (para mostrar "Psicología", etc.)
     */
    public function area()
    {
        return $this->belongsTo(AreaCanalizacion::class, 'id_area', 'id_area');
    }
}