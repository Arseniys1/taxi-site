<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Order;
use App\OrderPoint;
use Illuminate\Support\Facades\Auth;

class TaxiOrder extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'phone_number' => 'required|phone:RU|exists:users,phone_number',
            'points' => 'required|array|min:2',
            'points.*' => 'array|min:2|max:2',
            'points.*.*' => 'string',
            'delivery' => 'nullable|boolean',
            'children' => 'nullable|boolean',
            'comment' => 'nullable|string|max:5000',
        ]);

        $user = Auth::user();

        $order = new Order();
        $order->client_id = $user->id;
        $order->delivery = $request->has('delivery') ? $request->input('delivery') : false;
        $order->children = $request->has('children') ? $request->input('children') : false;
        $order->comment = $request->has('comment') ? $request->input('comment') : null;
        $order->save();

        $points = [];

        foreach ($request->input('points') as $point) {
            $points[] = [
                'order_id' => $order->id,
                'lat' => $point[0],
                'lng' => $point[1],
            ];
        }

        OrderPoint::insert($points);

        $order->load('points');

        return $this->success($order);
    }
}
