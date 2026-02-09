<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaCanalizacion extends Model
{
    protected $table = 'areas_canalizacion';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    public function canalizaciones()
    {
        return $this->hasMany(Canalizacion::class, 'id_area');
    }
}