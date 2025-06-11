<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleErrors
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Wystąpił błąd serwera',
                    'message' => config('app.debug') ? $e->getMessage() : 'Skontaktuj się z administratorem'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
        }
    }
}
