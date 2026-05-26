<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaReporte extends Model
{
    protected $table = 'firmas_reporte';
    protected $primaryKey = 'id_firma';

    protected $fillable = [
        'tipo',
        'nombre',
        'cargo',
        'activo',
        'orden'
    ];

    // obtener firmas por tipo
    public static function getByTipo($tipo)
    {
        return self::where('tipo', $tipo)
            ->where('activo', true)
            ->orderBy('orden')
            ->get();
    }

    // obtener firma activa por tipo
    public static function getActiva($tipo)
    {
        return self::where('tipo', $tipo)
            ->where('activo', true)
            ->orderBy('orden')
            ->first();
    }
}