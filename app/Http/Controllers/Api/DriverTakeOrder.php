<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Events\DriverTakeOrderEvent;

class DriverTakeOrder extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        $order = Order::where('id', '=', $request->input('order_id'))
            ->where('status', '=', 'created')
            ->first();

        if (!$order) {
            return $this->error('Order already taken.');
        }

        $order->driver_id = Auth::user()->id;
        $order->status = 'driver_in_way';
        $order->save();

        broadcast(new DriverTakeOrderEvent($order, Auth::user()));

        return $this->success($order);
    }
}
