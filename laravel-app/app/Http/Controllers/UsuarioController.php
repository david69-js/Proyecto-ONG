<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index()
    {
        $usuarios = Usuario::latest()->paginate(10);
        return view('usuario.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function crear()
    {
        return view('usuario.crear');
    }

    /**
     * Guardar un nuevo usuario
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|unique:usuarios',
            'telefono' => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'rol'      => 'required|in:administrador,coordinador,voluntario',
            'password' => 'required|min:6|confirmed',
        ]);

        Usuario::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'direccion'=> $request->direccion,
            'rol'      => $request->rol,
            'password' => Hash::make($request->password),
            'activo'   => true,
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Mostrar un usuario específico
     */
    public function mostrar(Usuario $usuario)
    {
        return view('usuario.mostrar', compact('usuario'));
    }

    /**
     * Mostrar formulario para editar usuario
     */
    public function editar(Usuario $usuario)
    {
        return view('usuario.editar', compact('usuario'));
    }

    /**
     * Actualizar un usuario existente
     */
    public function actualizar(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'rol'      => 'required|in:administrador,coordinador,voluntario',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['nombre', 'apellido', 'email', 'telefono', 'direccion', 'rol']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario
     */
    public function eliminar(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado.');
    }
}
