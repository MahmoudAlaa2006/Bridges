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
        /**
         * Register middleware aliases for role-based access control.
         */
        $middleware->alias([
            'candidate' => \App\Http\Middleware\CandidateMiddleware::class,
            'hr.admin' => \App\Http\Middleware\HRAdminMiddleware::class,
            'hr.employee' => \App\Http\Middleware\HREmployeeMiddleware::class,
            'interviewer' => \App\Http\Middleware\InterviewerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
