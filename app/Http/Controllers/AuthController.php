<?php

namespace App\Http\Controllers;

use App\Enum\Roles\RolesEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(RolesEnum::USER->value);

        $token = auth()->login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user->only('name', 'email'),
            'role' =>$user->getRoleNames()->first(),
            'authorization' => [
                'token' => $token,
                'token_type' => 'bearer',
            ]
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:8'],
        ]);

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => $user->only('name', 'email'),
            'role' =>$user->getRoleNames()->first(),
            'authorization' => [
                'token' => $token,
                'token_type' => 'bearer',
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = auth()->user();
        auth()->logout();


        return response()->json([
            'user' => $user->only('email'),
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }
}

