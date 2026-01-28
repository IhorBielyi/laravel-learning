<?php

use App\Domain\DeliveryPoint;
use App\Domain\Order;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function (Request $request) {
    $provider = $request->query('provider');
    $delivery = $request->query('delivery');
    $address = $request->query('address');

    $order = null;

    if ($provider !== null && $delivery !== null && $address !== null) {
        $deliveryPoint = new DeliveryPoint($provider, $delivery, $address);
        $order = new Order('Цукерки асорті', 1, 150.50, 10, $deliveryPoint);
    }

    return view('order', compact('order'));
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::get('/home', function () {
        $user = \Illuminate\Support\Facades\Auth::user();

        return response()->json([
            'status' => 'OK',
            'user' => $user->only( 'name' ),
            'message' => 'Hello! Welcome to our application!'
        ]);
    })->middleware('role:user|admin');

    Route::get('/profile', function () {
        $user = \Illuminate\Support\Facades\Auth::user();

        return response()->json([
            'status' => 'OK',
            'user' => $user->only( 'name' ),
            'message' => 'Hello! You have the role of user.'
        ]);
    })->middleware('role:user');

    Route::get('/admin', function () {
        return response()->json([
            'status' => 'OK',
            'message' => 'Hello! You have the role of admin.'
        ]);
    })->middleware('role:admin');
});



