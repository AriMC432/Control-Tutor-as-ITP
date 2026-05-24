<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteAnexo20 extends Model
{
    /**
     * nombre de la tabla asociada
     */
    protected $table = 'reportes_anexo20';

    /**
     * llave primaria de la tabla
     */
    protected $primaryKey = 'id_reporte';

    /**
     * campos que se pueden llenar masivamente
     */
    protected $fillable = [
        'id_coordinador',
        'id_carrera',
        'id_periodo',
        'datos_docentes',
        'problemas',
        'observaciones',
        'editado',
        'ultima_edicion',
        'ruta_pdf',
        'pdf_generado',
        'fecha_llenado',
        'fecha_entrega',
        'firma_jefe_nombre',
        'firma_jefe_cargo',
        'firma_coordinador_nombre',
        'firma_coordinador_cargo',
        'encabezado_ruta'
    ];

    /**
     * campos que se convierten automaticamente a array/objeto
     */
    protected $casts = [
        'datos_docentes' => 'array',
        'problemas' => 'array',
        'observaciones' => 'array',
        'editado' => 'boolean',
        'pdf_generado' => 'boolean',
        'ultima_edicion' => 'datetime'
    ];

    /**
     * relacion con el coordinador que genero el reporte
     */
    public function coordinador()
    {
        return $this->belongsTo(Docente::class, 'id_coordinador');
    }

    /**
     * relacion con la carrera del reporte
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }

    /**
     * relacion con el periodo del reporte
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }

    /**
     * verificar si el reporte es del periodo activo
     */
    public function esPeriodoActivo()
    {
        $periodoActivo = Periodo::where('activo', 1)->first();
        return $periodoActivo && $this->id_periodo == $periodoActivo->id_periodo;
    }

    /**
     * verificar si el reporte se puede editar
     */
    public function sePuedeEditar()
    {
        return $this->esPeriodoActivo() && !$this->pdf_generado;
    }
}