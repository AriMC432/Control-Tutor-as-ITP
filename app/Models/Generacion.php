<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generacion extends Model
{
    protected $table = 'generacion';
    protected $primaryKey = 'id_generacion';
    public $timestamps = false;

    protected $fillable = ['ano_inicio', 'ano_fin'];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_generacion');
    }
}