<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlreadyLoggedIn
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
        // When the user is trying to log in check first if they already logged in or not
        if( session()->has('LoggedUser') && (url('login') == $request->url()) ){
            return back();
        }
        return $next($request);
    }
}
