<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function showProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'OK',
            'user' => $user->only( 'email' ),
            'message' => 'Hello! This page for user!'
        ]);
    }

    public function showAdmin(): JsonResponse
    {
        $admin = Auth::user();

        return response()->json([
            'status' => 'OK',
            'user' => $admin->only( 'email' ),
            'message' => 'Hello! This page for admin!'
        ]);
    }

}
