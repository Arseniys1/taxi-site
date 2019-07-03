<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userSession = UserSession::where('token', '=', $request->header('Api-Auth'))->first();

        if (!$userSession || Carbon::now()->gt($userSession->expire_at)) {
            return response('Unauthorized', 401);
        }

        $user = User::find($userSession->user_id);
        Auth::login($user);

        return $next($request);
    }
}
