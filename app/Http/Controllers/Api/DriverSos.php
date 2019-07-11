<?php

namespace App\Http\Controllers\Api;

use App\Events\SosEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverSos extends ApiController
{
    public function get(Request $request) {
        broadcast(new SosEvent(Auth::user()));

        return $this->success(true);
    }
}
