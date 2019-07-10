<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permissions
{

    /**
     * @param $request
     * @param Closure $next
     * @param mixed ...$permissions
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        if (!Auth::check()) {
            return response()->json([
                'ok' => false,
                'error' => 'No auth.',
            ])->setStatusCode(401);
        }

        $permissionsResult = Auth::user()->hasPermissions($permissions);

        if (!$permissionsResult->result()) {
            return response()->json([
                'ok' => false,
                'error' => [
                    'message' => 'No permissions found.',
                    'permissions_result' => $permissionsResult->toArray(),
                ],
            ]);
        }

        return $next($request);
    }
}
