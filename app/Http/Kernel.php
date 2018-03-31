<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'privi' => \App\Http\Middleware\PriviMiddleware::class,
        'log' => \App\Http\Middleware\LogMiddleware::class,
        'front.auth' => \App\Http\Middleware\FrontAuth::class,
        'mobile.auth' => \App\Http\Middleware\MobileAuth::class,
        'demo.auth' => \App\Http\Middleware\DemoMiddleware::class,
        'cors' => \App\Http\Middleware\CORS::class,
        'jwt.auth' => \App\Http\Middleware\authJWT::class,
    ];
}
