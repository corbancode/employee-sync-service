<?php

use App\Enums\ResponseStatus;
use App\Exceptions\NoHandlerFoundForEmployeeProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NoHandlerFoundForEmployeeProvider $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => ResponseStatus::FAILED,
                    'message' => 'Invalid Provider'
                ], 422);
            }
        });
    })->create();
