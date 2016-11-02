<?php

namespace App\Http\Middleware;

use App\Logics\Facade\UserLogic;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $redirect = UserLogic::getUserInfo('admin') ? '/admin/index/index' : '/home/index/index';
            return orRedirect($redirect);
        }

        return $next($request);
    }
}
