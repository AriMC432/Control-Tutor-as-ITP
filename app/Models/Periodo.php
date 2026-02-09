<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodo';
    protected $primaryKey = 'id_periodo';
    public $timestamps = false;

    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'activo'];

    // Scope para obtener siempre el actual fácilmente
    public function scopeActual($query)
    {
        return $query->where('activo', 1);
    }
}