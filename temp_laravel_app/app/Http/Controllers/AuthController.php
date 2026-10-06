<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $this->validateLogin($request);
        $throttleKey = $this->throttleKey($validated['correo'], $request->ip());

        $this->ensureIsNotRateLimited($throttleKey, $request);

        if (! Auth::attempt([
            'correo' => $validated['correo'],
            'password' => $validated['password'],
        ])) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'correo' => 'Las credenciales proporcionadas no son validas.',
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('status', 'Sesion iniciada correctamente.');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $this->validateRegistration($request);

        User::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'cedula' => $validated['cedula'],
            'correo' => $validated['correo'],
            'password' => Hash::make($validated['password']),
            // El rol administrador no se expone en el registro publico.
            'rol' => User::ROL_ESTUDIANTE,
        ]);

        return redirect()->route('login')
            ->with('status', 'Usuario registrado correctamente. Ahora puedes iniciar sesion.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Sesion cerrada correctamente.');
    }

    protected function validateLogin(Request $request): array
    {
        $request->merge([
            'correo' => Str::lower(trim((string) $request->input('correo'))),
        ]);

        return $request->validate([
            'correo' => ['required', 'string', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingresa un correo valido.',
            'password.required' => 'La contrasena es obligatoria.',
            'password.min' => 'La contrasena debe tener al menos 8 caracteres.',
        ]);
    }

    protected function validateRegistration(Request $request): array
    {
        $request->merge([
            'nombre' => trim((string) $request->input('nombre')),
            'apellido' => trim((string) $request->input('apellido')),
            'cedula' => Str::upper((string) preg_replace('/\s+/', '', (string) $request->input('cedula'))),
            'correo' => Str::lower(trim((string) $request->input('correo'))),
        ]);

        return $request->validate([
            'nombre' => ['required', 'string', 'max:80'],
            'apellido' => ['required', 'string', 'max:80'],
            'cedula' => ['required', 'string', 'max:20', 'regex:/^[VEJPG]?-?[0-9]{5,12}$/i', 'unique:usuarios,cedula'],
            'correo' => ['required', 'string', 'email', 'max:120', 'unique:usuarios,correo'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'cedula.required' => 'La cedula es obligatoria.',
            'cedula.regex' => 'Ingresa una cedula valida.',
            'cedula.unique' => 'La cedula ya se encuentra registrada.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingresa un correo valido.',
            'correo.unique' => 'El correo ya se encuentra registrado.',
            'password.required' => 'La contrasena es obligatoria.',
            'password.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmacion de contrasena no coincide.',
        ]);
    }

    protected function ensureIsNotRateLimited(string $throttleKey, Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'correo' => "Demasiados intentos. Intenta nuevamente en {$seconds} segundos.",
        ]);
    }

    protected function throttleKey(string $correo, ?string $ip): string
    {
        return Str::lower($correo . '|' . $ip);
    }
}
