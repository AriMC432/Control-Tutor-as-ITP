<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeTutor extends Model
{
    protected $table = 'informes_tutores';

    protected $primaryKey = 'id_informe';

    protected $fillable = [
        'id_docente',
        'periodo',
        'archivo',
        'nombre_original',
        'estatus',
    ];

    public function docente()
    {
        return $this->belongsTo(
            Docente::class,
            'id_docente',
            'id_docente'
        );
    }
}
