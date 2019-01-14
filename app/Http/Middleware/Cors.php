<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
        ->header('Access-Controller-Allow-Origin' , '*')
        ->header('Access-Controller-Allow-Methods' , '*')
        ->header('Access-Controller-Allow-Headers' , 'Content-Type , Authorization');
    }
}
