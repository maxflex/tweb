<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
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
        $response = $next($request);

        // $response->header('Cache-Control', 'no-cache, must-revalidate');
        // Or whatever you want it to be:
        $response->header('Cache-Control', 'max-age=31557600');

        return $response;
    }
}
