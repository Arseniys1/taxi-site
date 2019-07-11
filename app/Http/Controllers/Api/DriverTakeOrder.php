<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;

class DriverTakeOrder extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        $order = Order::find($request->input('order_id'));

        $order->driver_id = Auth::user()->id;
        $order->status = 'driver_in_way';
        $order->save();

        return $this->success($order);
    }
}
