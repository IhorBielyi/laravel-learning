<?php

use App\Domain\DeliveryPoint;
use App\Domain\Order;
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



