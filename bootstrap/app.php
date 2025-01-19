<?php

use App\Http\Middleware\TokenAuthorizedCitizen;
use App\Http\Middleware\UserTypeAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "token.authorized_citizen"=>TokenAuthorizedCitizen::class,
            "user.type"=>UserTypeAuth::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
