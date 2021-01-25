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
        if (!empty($proxy_url)) {
            $request->setTrustedProxies([$proxy_url], Request::HEADER_X_FORWARDED_ALL);
        }
        $result = $next($request)->header('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', '*');
        //URL::forceRootUrl();
        return $result;
    }
}
