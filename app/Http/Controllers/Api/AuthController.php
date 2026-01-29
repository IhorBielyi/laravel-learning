<?php

namespace App\Http\Controllers\Api;

use App\Enum\Auth\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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

    public function register(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();

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
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

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
     * @return JsonResponse
     */
    public function logout(): JsonResponse
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

