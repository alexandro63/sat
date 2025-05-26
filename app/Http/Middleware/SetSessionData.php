<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user')) {
            $user = Auth::user();
            $session_data = [
                'user_id' => $user->id,
                'user_name' => $user->user_name,
                'user_names' => $user->people->per_nombres,
            ];

            $request->session()->put('user', $session_data);
        }

        return $next($request);
    }
}
