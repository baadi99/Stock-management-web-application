<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
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

        if( session('user_role') !== 'Admin' ){ // role_id == 1 => admin
            return abort(403); //Show an "forbidden" error page
        }

        return $next($request);
    }
}
