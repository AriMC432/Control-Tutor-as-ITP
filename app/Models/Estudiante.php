<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Estudiante extends Authenticatable
{
    use HasFactory, HasApiTokens;

    /*
    |--------------------------------------------------------------------------
    | TABLA
    |--------------------------------------------------------------------------
    */

    // Nombre de la tabla de estudiantes.
    protected $table = 'estudiante';

    // Llave primaria de la tabla.
    protected $primaryKey = 'id_estudiante';

    // La tabla no utiliza created_at / updated_at.
    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | CAMPOS PERMITIDOS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'num_control',
        'correo',
        'contrasena',
        'id_grupo',

        // Foto de perfil del estudiante.
        'foto',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAMPOS OCULTOS
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'contrasena',
    ];


    /*
    |--------------------------------------------------------------------------
    | AUTENTICACIÓN
    |--------------------------------------------------------------------------
    */

    /**
     * Laravel utiliza este método para obtener
     * la contraseña del estudiante durante el login.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }


    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON GRUPO
    |--------------------------------------------------------------------------
    */

    /**
     * Un estudiante pertenece a un grupo.
     */
    public function grupo()
    {
        return $this->belongsTo(
            Grupo::class,
            'id_grupo',
            'id_grupo'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON TUTORÍAS INDIVIDUALES
    |--------------------------------------------------------------------------
    */

    /**
     * Un estudiante puede tener muchas
     * tutorías individuales.
     */
    public function tutoriasIndividuales()
    {
        return $this->hasMany(
            TutoriaIndividual::class,
            'id_estudiante',
            'id_estudiante'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | URL DE LA FOTO DE PERFIL
    |--------------------------------------------------------------------------
    */

    /**
     * Devuelve automáticamente la URL pública
     * de la fotografía del estudiante.
     *
     * Ejemplo:
     *
     * storage/fotos/estudiantes/12345678.jpg
     *
     * Si el estudiante no tiene foto,
     * se utiliza el avatar predeterminado.
     */
    public function getFotoUrlAttribute()
    {
        // Si existe un nombre de archivo guardado
        // en la columna "foto", construimos su URL.
        if (!empty($this->foto)) {

            return asset(
                'storage/fotos/estudiantes/' . $this->foto
            );
        }

        // Si no tiene fotografía,
        // mostramos la imagen predeterminada.
        return asset('images/default-avatar.png');
    }


    /*
    |--------------------------------------------------------------------------
    | RUTA DE ALMACENAMIENTO
    |--------------------------------------------------------------------------
    */

    /**
     * Devuelve la ruta relativa donde se almacena
     * la fotografía del estudiante.
     */
    public function getFotoPathAttribute()
    {
        // Si existe una fotografía registrada,
        // utilizamos directamente ese nombre.
        if (!empty($this->foto)) {

            return 'fotos/estudiantes/' . $this->foto;
        }

        // Ruta que se utilizaría para una foto
        // basada en el número de control.
        return 'fotos/estudiantes/' .
               $this->num_control .
               '.jpg';
    }
}