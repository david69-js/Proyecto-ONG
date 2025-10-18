<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            // El correo no existe
            return back()->withErrors([
                'email' => 'El correo ingresado no está registrado.',
            ])->withInput($request->except('password'));
        }

        if (! Hash::check($request->password, $user->password)) {
            // El correo existe pero la contraseña es incorrecta
            return back()->withErrors([
                'password' => 'La contraseña ingresada es incorrecta.',
            ])->withInput($request->except('password'));
        }

        if (! $user->is_active) {
            // (Opcional) Usuario inactivo
            return back()->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ]);
        }

        // Si llega aquí, las credenciales son correctas → iniciar sesión
        Auth::login($user, $request->has('remember'));

        $request->session()->regenerate();

        // Actualizar último login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        return redirect()->intended('/users');
    }


    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sys_users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_active' => true,
            'is_verified' => false, // Requiere verificación por email
        ]);

        // Asignar rol de beneficiario por defecto a nuevos usuarios
        $user->assignRole('beneficiary');

        Auth::login($user);

        return redirect('/users')->with('success', '¡Cuenta creada exitosamente!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
