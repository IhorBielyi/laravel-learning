<?php

namespace App\Http\Controllers\Web;

use App\Domain\DeliveryPoint;
use App\Domain\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function createOrder(Request $request): View
    {
        $order = $this->tryCreateOrderFromRequest($request);

        return view('order', compact('order'));
    }

    private function tryCreateOrderFromRequest(Request $request): ?Order
    {
        $provider = $request->query('provider');
        $delivery = $request->query('delivery');
        $address = $request->query('address');

        if ($provider === null || $delivery === null || $address === null) {
            return null;
        }

        $deliveryPoint = new DeliveryPoint($provider, $delivery, $address);

        return new Order('Цукерки асорті', 1, 150.50, 10, $deliveryPoint);
    }

}
