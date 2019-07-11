<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Order;

class GetDriverCreatedOrders extends ApiController
{
    private $take = 100;
    private $skip = 0;

    public function get(Request $request) {
        $this->validate($request, [
            'take' => 'nullable|integer|min:1|max:100',
            'skip' => 'nullable|integer|min:0|max:100',
        ]);

        if ($request->has('take')) $this->take = $request->input('take');
        if ($request->has('skip')) $this->skip = $request->input('skip');

        return $this->success(Order::where('status', '=', 'created')
            ->take($this->take)
            ->skip($this->skip)
            ->get());
    }
}
