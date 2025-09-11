<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;

class InviteController extends Controller
{
    //
    private const TOKEN = 'participar-no-chat';

    public function show($token)
    {
        if ($token !== self::TOKEN) {
            return redirect()->route('login')->with('error', 'Link de convite inválido');
        }

        return view('auth/token-register',['token' => $token]);
    }

    public function register(Request $request, $token)
    {
        if ($token !== self::TOKEN) {
            return redirect()->route('login')->with('error', 'Link de convite inválido');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'permission' => 'user',
            'status' => 'online',
            'invite_token_used' => $token
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public static function getToken()
    {
        return self::TOKEN;
    }
}
