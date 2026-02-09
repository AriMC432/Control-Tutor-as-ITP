<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Dashboard principal del SuperAdmin
     */
    public function index()
    {
        return view('superadmin.index');
    }

    /**
     * Muestra el formulario para crear un nuevo docente/usuario
     */
    public function createDocente()
    {
        $roles = Rol::all(); 
        return view('superadmin.crear_docente', compact('roles'));
    }

    /**
     * Guarda el nuevo docente en la base de datos
     */
    public function storeDocente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'num_control' => 'required|string|unique:docente,num_control',
            'correo' => 'required|email|unique:docente,correo',
            'password' => 'required|string|min:6',
            'id_rol' => 'required|exists:roles,id_rol'
        ]);

        Docente::create([
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'num_control' => $request->num_control,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->password), // Encriptación
            'id_rol' => $request->id_rol
        ]);

        return back()->with('success', 'Usuario registrado exitosamente.');
    }
}