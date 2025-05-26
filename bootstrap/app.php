<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\SetSessionData;
use App\Http\Middleware\AtlantisSidebarMenu;
use App\Http\Middleware\CheckUserLogin;
use Illuminate\Auth\Middleware\Authenticate as AuthenticateCore;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareRegistrar;
use Illuminate\Foundation\Configuration\Exceptions; // Verificar existencia

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (MiddlewareRegistrar $middleware) {
        // Para middleware globales en el grupo "web"
        // $middleware->append(AtlantisSidebarMenu::class);
        // $middleware->append(SetSessionData::class);

        // Alias para uso en rutas
        $middleware->alias([
            'atlantis_menu'      => AtlantisSidebarMenu::class,
            'set_session_data'   => SetSessionData::class,
            'check_user_login'   => CheckUserLogin::class,
            'auth'               => AuthenticateCore::class,
            'auth.basic'         => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session'       => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers'      => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can'                => \Illuminate\Auth\Middleware\Authorize::class,
            'guest'              => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm'   => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed'             => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle'           => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified'           => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
