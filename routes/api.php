<?php

use App\Enum\Auth\PermissionsEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ApiController::class, 'showProfile'])
        ->middleware('permission:' . PermissionsEnum::PROFILE_VIEW->value);
    Route::get('/admin', [ApiController::class, 'showAdmin'])
        ->middleware('permission:' . PermissionsEnum::ADMIN_VIEW->value);
});



