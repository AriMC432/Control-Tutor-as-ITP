<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncabezadoReporte extends Model
{
    protected $table = 'encabezados_reporte';
    protected $primaryKey = 'id_encabezado';

    protected $fillable = [
        'id_periodo',
        'tipo_reporte',
        'ruta_imagen',
        'nombre_original',
        'tamano_bytes',
        'mime_type',
        'activo',
        'subido_por',
        'subido_por_rol',
        'ancho',
        'alto'
    ];

    /**
     * obtener el periodo asociado a este encabezado
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }

    /**
     * obtener el docente que subio la imagen
     */
    public function subidoPor()
    {
        return $this->belongsTo(Docente::class, 'subido_por');
    }

    /**
     * obtener el encabezado activo para un periodo
     */
    public static function getActivoPorPeriodo($id_periodo = null)
    {
        $query = self::where('activo', true);

        if ($id_periodo) {
            $query->where('id_periodo', $id_periodo);
        } else {
            $query->whereNull('id_periodo');
        }

        return $query->first();
    }
}
