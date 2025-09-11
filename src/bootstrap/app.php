<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->as('api.v1.')
                ->group(function () {
                    $routePrefixes = collect(scandir(base_path('routes/api/v1/')))
                        ->slice(2)
                        ->values()
                        ->map(fn ($file) => explode('.', $file)[0])
                        ->toArray();

                    foreach ($routePrefixes as $prefix) {
                        Route::prefix("/{$prefix}")
                            ->as("{$prefix}.")
                            ->group(base_path("routes/api/v1/{$prefix}.php"));
                    }
                });

        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
