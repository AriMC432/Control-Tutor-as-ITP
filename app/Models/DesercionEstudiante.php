<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesercionEstudiante extends Model
{
    // nombre la tabla
    protected $table = 'desercion_estudiante';

    // llave primaria
    protected $primaryKey = 'id_desercion';

   // campos que se pueden llenar
    protected $fillable = [
        'id_estudiante',
        'id_periodo',
        'tipo_desercion',
        'motivo_desercion',
        'fecha_desercion'
    ];

    // tipos de desercion o estatus
    const TIPO_ACTIVO = 'activo';
    const TIPO_BAJA_TEMPORAL = 'baja_temporal';
    const TIPO_BAJA_DEFINITIVA = 'baja_definitiva';

    // relacion con estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    // relacion con periodo academico
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
}
