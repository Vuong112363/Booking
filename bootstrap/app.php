<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware): void {

    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user'  => \App\Http\Middleware\UserMiddleware::class,
        'check.maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
    ]);

})
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Cấu hình Render lỗi
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            
            // 1. Nếu lỗi xảy ra trong các link admin (ví dụ: localhost:8000/admin/abc)
            if ($request->is('admin/*')) {
                // Hãy chắc chắn bạn có file: resources/views/admin/errors/404.blade.php
                return response()->view('admin.errors.404', [], 404);
            }

            return response()->view('Clients.errors.404', [], 404);
        });

    })->create();