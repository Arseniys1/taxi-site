<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverOnline extends ApiController
{
    public function get(Request $request) {
        $user_meta_online = Auth::user()
            ->meta
            ->where('meta_name', '=', 'driver_online')
            ->first();

        $user_meta_online->meta_data = true;
        $user_meta_online->save();

        return $this->success(true);
    }
}
