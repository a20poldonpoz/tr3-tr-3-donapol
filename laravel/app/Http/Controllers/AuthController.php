<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 


class AuthController extends Controller
{
    public function register(Request $request)
    {
      $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'tipus' => 'string', // 'user' or 'admin
        'password' => 'required|string',
    ]);

    if ($request->tipus != null) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tipus' => $request->tipus,
            'password' => bcrypt($request->password),
        ]);
    }else{

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
      }
        return response()->json(['message' => 'User registered successfully']);
    }

    public function getUserId(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        return response()->json(compact('user'));
    }

    public function login(Request $request)
{
    // Validación aquí

    $credentials = $request->only('email', 'password');

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Aquí puedes incluir el tipo de usuario en la respuesta
    return response()->json(['message' => 'Login successful', 'tipus' => $user->tipus]);
}


    public function checkAuth(Request $request)
    {
        if (Auth::check()) {
            // El usuario está autenticado
            return response()->json(['authenticated' => true, 'user' => Auth::user()]);
        } else {
            // El usuario no está autenticado
            return response()->json(['authenticated' => false]);
        }
    }
}
