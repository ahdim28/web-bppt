<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Maintenance
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
        $segment = request()->segment(1);

        if (config('custom.maintenance.mode') == TRUE) {
            if ($segment != 'backend' && $segment != 'admin' && $segment != 'maintenance') {
                return redirect()->route('is_maintenance');
            }
        }

        return $next($request);
    }
}
