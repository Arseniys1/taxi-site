<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetUser extends ApiController
{
    public function get(Request $request) {
        return $this->success(Auth::user()->load('permissions'));
    }
}
