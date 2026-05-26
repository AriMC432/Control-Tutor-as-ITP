<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteAnexo19 extends Model
{
    protected $table = 'reportes_anexo19';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'id_docente',
        'id_grupo',
        'id_periodo',
        'datos_estudiantes',
        'problemas',
        'indicadores',
        'medio_comunicacion',
        'id_encabezado_usado',
        'editado',
        'ultima_edicion',
        'ruta_pdf',
        'pdf_generado',
        'fecha_llenado',
        'fecha_entrega',
        'firma_coordinador_nombre',
        'firma_coordinador_cargo',
        'firma_jefe_nombre',
        'firma_jefe_cargo',
        'encabezado_ruta'
    ];

    protected $casts = [
        'datos_estudiantes' => 'array',
        'problemas' => 'array',
        'indicadores' => 'array',
        'editado' => 'boolean',
        'pdf_generado' => 'boolean',
        'ultima_edicion' => 'datetime'
    ];

    /**
     * relacion con el docente que genero el reporte
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    /**
     * relacion con el grupo del reporte
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    /**
     * relacion con el periodo del reporte
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }

    /**
     * relacion con el encabezado usado en el reporte
     */
    public function encabezado()
    {
        return $this->belongsTo(EncabezadoReporte::class, 'id_encabezado_usado');
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