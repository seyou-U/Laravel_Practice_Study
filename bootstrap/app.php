<?php

use App\Http\Middleware\HeaderDumper;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // グローバルミドルウェアの登録
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(HeaderDumper::class);

        // ミドルウェアエイリアスの登録
        $middleware->alias([
            'headerDumper' => HeaderDumper::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
