<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AllowProxy
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
        $proxy_url = env('ALLOWED_PROXY');
        // dd($request->getTrustedProxies());
        $result = $next($request);
        //URL::forceRootUrl();
        return $result;
    }
}
