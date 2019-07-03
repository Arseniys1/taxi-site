<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function success($response = null) {
        return response()->json([
            'ok' => true,
            'response' => $response
        ]);
    }

    public function error($error = null) {
        return response()->json([
            'ok' => false,
            'error' => $error
        ]);
    }
}
