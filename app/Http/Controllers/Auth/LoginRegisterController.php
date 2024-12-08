<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->only(['showRegistrationForm', 'register', 'showLoginForm', 'login']);
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,email',
            'contraseña' => 'required|string|min:8',
            'rol' => 'required|string|in:cliente,psicólogo',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->correo,
            'password' => Hash::make($request->contraseña),
            'rol' => $request->rol,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['correo'], 'password' => $credentials['contraseña']])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }
} 