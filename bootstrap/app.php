<?php

use App\Http\Middleware\ForceHttps;
use App\Http\Middleware\SecurityHeader;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [SecurityHeader::class]);

        $middleware->alias(['throttle.login' => ThrottleRequests::class]);

        $middleware->web(append: [ForceHttps::class]);

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangkap QueryException dari semua controller
    $exceptions->render(function (QueryException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }
        if (app()->isProduction()) {
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan sistem!');
        }
    });

    // Tangkap 404
    $exceptions->render(function (NotFoundHttpException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Not found'], 404);
        }
        if (app()->isProduction()) {
            return redirect()->route('dashboard')->with('error', 'Halaman tidak ditemukan!');
        }
    });

    $exceptions->render(function (AuthorizationException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        if (app()->isProduction()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses!');
        }
        abort(403, $e->getMessage());
    });
    })->create();
