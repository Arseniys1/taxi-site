<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;

class GetTaxiOrder extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::find($request->input('order_id'));

        if (Auth::user()->id != $order->client_id || Auth::user()->id != $order->driver_id) {
            return $this->error('You do not participate in this order.');
        }

        $order->load('points');

        return $this->success($order);
    }
}
