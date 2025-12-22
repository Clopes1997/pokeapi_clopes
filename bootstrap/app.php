<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            // Tests expect 422 (not 302 redirect) and also check session errors + message in body.
            $bag = new ViewErrorBag();
            $bag->put('default', new MessageBag($e->errors()));

            if ($request->hasSession()) {
                $request->session()->flash('errors', $bag);
            }

            return response()
                ->view('errors.422', ['errors' => $bag], 422);
        });
    })->create();
