<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cache;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   \DateTimeInterface|\DateInterval|int $time Remembering time
     * @param bool $UserAgnostic if it is agnostic to the user
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $time, bool $UserAgnostic = false)
    {
        if (!Auth::guest() && !$UserAgnostic) {
            $key = 'request|' . $request->url() . '|' . Auth::user()->id;
        } else {
            $key = 'request|' . $request->url() . '|';
        }
        //dump('start CacheMiddleware with key' . $key);
        if (strtolower($request->input('no-cache')) != 'false')
            return $next($request);
        else
            return Cache::remember($key, $time, function () use ($request, $next) {
                return $next($request);
            });
    }
}
