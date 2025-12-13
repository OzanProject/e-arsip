<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // --- START: Middleware Aliases Kustom ---
        // HANYA MIDDLEWARE YANG DIDAFTARKAN DI SINI
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        // --- END: Middleware Aliases Kustom ---

        // Di sini Anda juga bisa menambahkan Global Middleware jika diperlukan
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();