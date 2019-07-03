<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ResendActivationCode extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'phone_number' => 'required|phone:RU|exists:users,phone_number',
        ]);
    }
}
