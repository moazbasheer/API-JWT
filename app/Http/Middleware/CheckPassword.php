<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->api_password !== env("API_PASSWORD", "0sp4P7z9Txb6WCi6X2Ts6xDGfo9aObHoMUPmCeoHFV3rpdssnyPAqeQkAgtwbtAL")) {
            return response()->json(["message" => "Unauthenticated"]);
        }
        return $next($request);
    }
}
