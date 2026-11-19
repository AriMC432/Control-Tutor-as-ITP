<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    protected $table = 'asesores';

    protected $fillable = [
        'nombre',
        'correo_institucional',
        'area',
        'horarios',
        'modalidad',
        'estado',
        'lugar_tipo',
        'lugar_detalle',
    ];

    protected $casts = [
        'horarios' => 'array',
    ];
}
