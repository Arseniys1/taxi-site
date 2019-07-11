<?php

namespace App\Http\Controllers\Api;

use App\Events\DriverChatMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverChatMessage extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'message' => 'required|string|min:1|max:1000',
        ]);

        broadcast(new DriverChatMessageEvent(Auth::user(), $request->input('message')));

        return $this->success(true);
    }
}
