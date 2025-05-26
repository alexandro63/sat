<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Superadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $superadmin_list = config('constants.superadmin_usernames');
        if (!empty($request->user()) && in_array(strtolower($request->user()->user_name), explode(',', strtolower($superadmin_list)))) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
