<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Handle 404 errors
        if ($e instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Nie znaleziono zasobu',
                    'code' => 404
                ], 404);
            }
            return response()->view('errors.404', [], 404);
        }

        // Handle 405 Method Not Allowed
        if ($e instanceof MethodNotAllowedHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Niedozwolona metoda HTTP',
                    'code' => 405
                ], 405);
            }
            return response()->view('errors.405', [], 405);
        }

        // Handle validation errors
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Błędy walidacji',
                    'errors' => $e->errors()
                ], 422);
            }
        }

        // Handle database errors
        if ($e instanceof \Illuminate\Database\QueryException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Błąd bazy danych',
                    'message' => config('app.debug') ? $e->getMessage() : 'Skontaktuj się z administratorem'
                ], 500);
            }
            
            return redirect()->back()
                           ->with('error', 'Wystąpił błąd bazy danych. Spróbuj ponownie lub skontaktuj się z administratorem.');
        }

        return parent::render($request, $e);
    }
}