<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    // Mostrar formulario de login web
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('itventory-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Login de usuario (API)
    public function login(Request $request)
    {
        // Validación del formulario web
        if ($request->has('email') && $request->has('password') && !$request->expectsJson()) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }

        // Login API (token)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no son correctas.'],
            ]);
        }

        $token = $user->createToken('itventory-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // Logout (web y API)
    public function logout(Request $request)
    {
        // Logout web
        if ($request->user() && $request->expectsJson() === false) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
        }

        // Logout API
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Token eliminado correctamente.'
            ]);
        }
    }
}
