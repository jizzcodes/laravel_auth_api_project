<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('referer') . '|' . $request->header('xmin');

        $limiter = app(RateLimiter::class)->limit($key, 60, 1); // 60 requests per minute

        if (!$limiter->tooManyAttempts()) {
            $limiter->hit();
            return $next($request);
        }

        return response('Too Many Attempts.', 429);
    }
}
