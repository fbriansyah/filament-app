<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoggingContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceID = $request->header('X-Trace-ID') ?? Str::uuid()->toString();
        Log::shareContext(array_filter([
            'correlation_id' => Str::uuid()->toString(),
            'trace_id' => $traceID,
        ]));

        return $next($request);
    }
}
