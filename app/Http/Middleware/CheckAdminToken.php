<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use \App\Http\Traits\MessagesTrait;

class CheckAdminToken
{
    use MessagesTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try {
            $token = $request->header('auth-token');
            $request->headers->set('Authorization', 'Bearer ' . $token, true);
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response($this->sendError('INVALID_TOKEN'), 400);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response($this->sendError('EXPIRED_TOKEN'), 400);
            } else {
                return response($this->sendError('TOKEN_NOTFOUND'), 404);
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response($this->sendError('INVALID_TOKEN'), 400);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response($this->sendError('EXPIRED_TOKEN'), 400);
            } else {
                return response($this->sendError('TOKEN_NOTFOUND'), 400);
            }
        }

        if (!$user)
            return response($this->sendError(trans('Unauthenticated')), 400);
        return $next($request);
    }
}
