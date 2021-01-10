<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cache;

use Closure;
use Illuminate\Http\Request;

class CacheMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   $time
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $time)
    {
        $key = 'request|'.$request->url().'|'. \Auth::user()->id;
        //dump('start CacheMiddleware with key' . $key);
        if ( strtolower($request->input('no-cache')) != 'false')
            return $next($request);
        else
            return Cache::remember($key, $time, function () use ($request,$next ) {
                return $next($request);
        } ); 
    }
}
