<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemaPeriodo extends Model
{
    // nombre de la tabla
    protected $table = 'problemas_periodo';

   // llave de la tabla
    protected $primaryKey = 'id_problema';

    // campos q se pueden llenar 
    protected $fillable = [
        'id_docente',
        'id_periodo',
        'id_grupo',
        'descripcion_problema',
        'solucion_recomendada',
        'numero_estudiantes',
        'orden'
    ];

   // relacion con el docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

   // relacion con el periodo
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }

    // relacion con el grupo 
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }
}
